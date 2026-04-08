const express = require('express');
const { body, validationResult } = require('express-validator');
const db = require('../config/database');
const { authenticateToken, authorizeRoles } = require('../middleware/auth');

const router = express.Router();

// Obtener perfil del usuario
router.get('/profile', authenticateToken, async (req, res) => {
  try {
    const userResult = await db.query(
      'SELECT id, email, first_name, last_name, phone, role, created_at FROM users WHERE id = $1',
      [req.user.id]
    );

    if (userResult.rows.length === 0) {
      return res.status(404).json({ error: 'Usuario no encontrado' });
    }

    const user = userResult.rows[0];

    // Si es un taller, obtener información adicional
    if (user.role === 'workshop') {
      const workshopResult = await db.query(
        'SELECT * FROM workshops WHERE user_id = $1',
        [req.user.id]
      );

      if (workshopResult.rows.length > 0) {
        user.workshop = workshopResult.rows[0];
      }
    }

    res.json({ user });
  } catch (error) {
    console.error('Error obteniendo perfil:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Actualizar perfil del usuario
router.put('/profile', authenticateToken, [
  body('firstName').optional().trim().isLength({ min: 2 }),
  body('lastName').optional().trim().isLength({ min: 2 }),
  body('phone').optional().isMobilePhone()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { firstName, lastName, phone } = req.body;

    const result = await db.query(
      `UPDATE users SET 
       first_name = COALESCE($1, first_name),
       last_name = COALESCE($2, last_name),
       phone = COALESCE($3, phone),
       updated_at = CURRENT_TIMESTAMP
       WHERE id = $4 RETURNING id, email, first_name, last_name, phone, role`,
      [firstName, lastName, phone, req.user.id]
    );

    res.json({
      message: 'Perfil actualizado exitosamente',
      user: result.rows[0]
    });
  } catch (error) {
    console.error('Error actualizando perfil:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Obtener notificaciones del usuario
router.get('/notifications', authenticateToken, async (req, res) => {
  try {
    const { page = 1, limit = 20 } = req.query;
    const offset = (page - 1) * limit;

    const result = await db.query(
      `SELECT * FROM notifications 
       WHERE user_id = $1 
       ORDER BY created_at DESC 
       LIMIT $2 OFFSET $3`,
      [req.user.id, limit, offset]
    );

    // Marcar como leídas
    await db.query(
      'UPDATE notifications SET is_read = true WHERE user_id = $1 AND is_read = false',
      [req.user.id]
    );

    res.json({
      notifications: result.rows,
      pagination: {
        page: parseInt(page),
        limit: parseInt(limit)
      }
    });
  } catch (error) {
    console.error('Error obteniendo notificaciones:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Crear reseña (solo clientes que han completado una cita)
router.post('/reviews', authenticateToken, authorizeRoles('client'), [
  body('appointmentId').isInt(),
  body('rating').isInt({ min: 1, max: 5 }),
  body('comment').optional().trim().isLength({ max: 500 })
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { appointmentId, rating, comment } = req.body;

    // Verificar que la cita existe, pertenece al usuario y está completada
    const appointmentResult = await db.query(
      'SELECT * FROM appointments WHERE id = $1 AND client_id = $2 AND status = $3',
      [appointmentId, req.user.id, 'completed']
    );

    if (appointmentResult.rows.length === 0) {
      return res.status(400).json({ error: 'Cita no válida para reseña' });
    }

    const appointment = appointmentResult.rows[0];

    // Verificar que no existe ya una reseña
    const existingReview = await db.query(
      'SELECT id FROM reviews WHERE appointment_id = $1',
      [appointmentId]
    );

    if (existingReview.rows.length > 0) {
      return res.status(400).json({ error: 'Ya existe una reseña para esta cita' });
    }

    // Crear la reseña
    const reviewResult = await db.query(
      `INSERT INTO reviews (appointment_id, client_id, workshop_id, rating, comment)
       VALUES ($1, $2, $3, $4, $5) RETURNING *`,
      [appointmentId, req.user.id, appointment.workshop_id, rating, comment]
    );

    // Actualizar rating promedio del taller
    await db.query(
      `UPDATE workshops SET 
       rating = (SELECT AVG(rating) FROM reviews WHERE workshop_id = $1),
       total_reviews = (SELECT COUNT(*) FROM reviews WHERE workshop_id = $1)
       WHERE id = $1`,
      [appointment.workshop_id]
    );

    res.status(201).json({
      message: 'Reseña creada exitosamente',
      review: reviewResult.rows[0]
    });
  } catch (error) {
    console.error('Error creando reseña:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

module.exports = router;