const express = require('express');
const { body, validationResult, query } = require('express-validator');
const db = require('../config/database');
const { authenticateToken, authorizeRoles } = require('../middleware/auth');

const router = express.Router();

// Crear nueva cita
router.post('/', authenticateToken, authorizeRoles('client'), [
  body('workshopId').isInt(),
  body('serviceId').isInt(),
  body('appointmentDate').isISO8601(),
  body('appointmentTime').matches(/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/),
  body('vehicleInfo').optional().isObject()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const {
      workshopId,
      serviceId,
      appointmentDate,
      appointmentTime,
      clientNotes,
      vehicleInfo
    } = req.body;

    // Verificar que el servicio pertenece al taller
    const serviceResult = await db.query(
      'SELECT s.*, w.business_name FROM services s JOIN workshops w ON s.workshop_id = w.id WHERE s.id = $1 AND s.workshop_id = $2',
      [serviceId, workshopId]
    );

    if (serviceResult.rows.length === 0) {
      return res.status(400).json({ error: 'Servicio no válido para este taller' });
    }

    const service = serviceResult.rows[0];

    // Verificar disponibilidad (no permitir citas duplicadas en la misma fecha/hora)
    const conflictResult = await db.query(
      `SELECT id FROM appointments 
       WHERE workshop_id = $1 AND appointment_date = $2 AND appointment_time = $3 
       AND status NOT IN ('cancelled', 'completed')`,
      [workshopId, appointmentDate, appointmentTime]
    );

    if (conflictResult.rows.length > 0) {
      return res.status(400).json({ error: 'Horario no disponible' });
    }

    // Crear la cita
    const result = await db.query(
      `INSERT INTO appointments 
       (client_id, workshop_id, service_id, appointment_date, appointment_time, client_notes, vehicle_info, total_price)
       VALUES ($1, $2, $3, $4, $5, $6, $7, $8) RETURNING *`,
      [req.user.id, workshopId, serviceId, appointmentDate, appointmentTime, clientNotes, vehicleInfo, service.price]
    );

    const appointment = result.rows[0];

    // Crear notificación para el taller
    await db.query(
      `INSERT INTO notifications (user_id, title, message, type, data)
       SELECT user_id, 'Nueva cita solicitada', 
              'Tienes una nueva solicitud de cita para ' || $2,
              'new_appointment', $3
       FROM workshops WHERE id = $1`,
      [workshopId, service.name, JSON.stringify({ appointmentId: appointment.id })]
    );

    res.status(201).json({
      message: 'Cita creada exitosamente',
      appointment: {
        ...appointment,
        service_name: service.name,
        workshop_name: service.business_name
      }
    });
  } catch (error) {
    console.error('Error creando cita:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Obtener citas del usuario
router.get('/my-appointments', authenticateToken, [
  query('status').optional().isIn(['pending', 'confirmed', 'in_progress', 'completed', 'cancelled']),
  query('page').optional().isInt({ min: 1 }),
  query('limit').optional().isInt({ min: 1, max: 50 })
], async (req, res) => {
  try {
    const { status, page = 1, limit = 20 } = req.query;
    const offset = (page - 1) * limit;

    let query = `
      SELECT a.*, s.name as service_name, s.duration_minutes,
             w.business_name, w.address, w.phone as workshop_phone
      FROM appointments a
      JOIN services s ON a.service_id = s.id
      JOIN workshops w ON a.workshop_id = w.id
      WHERE 1=1
    `;

    const params = [];
    let paramIndex = 1;

    // Filtrar por rol del usuario
    if (req.user.role === 'client') {
      query += ` AND a.client_id = $${paramIndex}`;
      params.push(req.user.id);
      paramIndex++;
    } else if (req.user.role === 'workshop') {
      query += ` AND a.workshop_id = (SELECT id FROM workshops WHERE user_id = $${paramIndex})`;
      params.push(req.user.id);
      paramIndex++;
    }

    // Filtrar por estado
    if (status) {
      query += ` AND a.status = $${paramIndex}`;
      params.push(status);
      paramIndex++;
    }

    query += ` ORDER BY a.appointment_date DESC, a.appointment_time DESC LIMIT $${paramIndex} OFFSET $${paramIndex + 1}`;
    params.push(limit, offset);

    const result = await db.query(query, params);

    res.json({
      appointments: result.rows,
      pagination: {
        page: parseInt(page),
        limit: parseInt(limit)
      }
    });
  } catch (error) {
    console.error('Error obteniendo citas:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Actualizar estado de cita (para talleres)
router.patch('/:id/status', authenticateToken, authorizeRoles('workshop'), [
  body('status').isIn(['confirmed', 'in_progress', 'completed', 'cancelled']),
  body('workshopNotes').optional().isString()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { id } = req.params;
    const { status, workshopNotes } = req.body;

    // Verificar que la cita pertenece al taller del usuario
    const appointmentResult = await db.query(
      `SELECT a.*, w.user_id as workshop_user_id, u.first_name, u.last_name
       FROM appointments a
       JOIN workshops w ON a.workshop_id = w.id
       JOIN users u ON a.client_id = u.id
       WHERE a.id = $1`,
      [id]
    );

    if (appointmentResult.rows.length === 0) {
      return res.status(404).json({ error: 'Cita no encontrada' });
    }

    const appointment = appointmentResult.rows[0];

    if (appointment.workshop_user_id !== req.user.id) {
      return res.status(403).json({ error: 'No tienes permisos para modificar esta cita' });
    }

    // Actualizar la cita
    const updateResult = await db.query(
      `UPDATE appointments SET status = $1, workshop_notes = $2, updated_at = CURRENT_TIMESTAMP 
       WHERE id = $3 RETURNING *`,
      [status, workshopNotes, id]
    );

    // Crear notificación para el cliente
    const statusMessages = {
      confirmed: 'Tu cita ha sido confirmada',
      in_progress: 'Tu servicio está en progreso',
      completed: 'Tu servicio ha sido completado',
      cancelled: 'Tu cita ha sido cancelada'
    };

    await db.query(
      `INSERT INTO notifications (user_id, title, message, type, data)
       VALUES ($1, $2, $3, 'appointment_update', $4)`,
      [
        appointment.client_id,
        'Actualización de cita',
        statusMessages[status],
        JSON.stringify({ appointmentId: id, status })
      ]
    );

    res.json({
      message: 'Estado de cita actualizado exitosamente',
      appointment: updateResult.rows[0]
    });
  } catch (error) {
    console.error('Error actualizando cita:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Cancelar cita (para clientes)
router.patch('/:id/cancel', authenticateToken, authorizeRoles('client'), async (req, res) => {
  try {
    const { id } = req.params;

    // Verificar que la cita pertenece al cliente
    const appointmentResult = await db.query(
      'SELECT * FROM appointments WHERE id = $1 AND client_id = $2',
      [id, req.user.id]
    );

    if (appointmentResult.rows.length === 0) {
      return res.status(404).json({ error: 'Cita no encontrada' });
    }

    const appointment = appointmentResult.rows[0];

    if (appointment.status === 'cancelled') {
      return res.status(400).json({ error: 'La cita ya está cancelada' });
    }

    if (appointment.status === 'completed') {
      return res.status(400).json({ error: 'No se puede cancelar una cita completada' });
    }

    // Cancelar la cita
    await db.query(
      'UPDATE appointments SET status = $1, updated_at = CURRENT_TIMESTAMP WHERE id = $2',
      ['cancelled', id]
    );

    // Notificar al taller
    await db.query(
      `INSERT INTO notifications (user_id, title, message, type, data)
       SELECT w.user_id, 'Cita cancelada', 
              'Un cliente ha cancelado su cita',
              'appointment_cancelled', $2
       FROM appointments a
       JOIN workshops w ON a.workshop_id = w.id
       WHERE a.id = $1`,
      [id, JSON.stringify({ appointmentId: id })]
    );

    res.json({ message: 'Cita cancelada exitosamente' });
  } catch (error) {
    console.error('Error cancelando cita:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

module.exports = router;