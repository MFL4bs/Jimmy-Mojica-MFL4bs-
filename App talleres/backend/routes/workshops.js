const express = require('express');
const { body, validationResult, query } = require('express-validator');
const db = require('../config/database');
const { authenticateToken, authorizeRoles } = require('../middleware/auth');

const router = express.Router();

// Buscar talleres con filtros y geolocalización
router.get('/search', [
  query('lat').optional().isFloat(),
  query('lng').optional().isFloat(),
  query('radius').optional().isInt({ min: 1, max: 50 }),
  query('category').optional().isString(),
  query('page').optional().isInt({ min: 1 }),
  query('limit').optional().isInt({ min: 1, max: 50 })
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const { lat, lng, radius = 10, category, page = 1, limit = 20 } = req.query;
    const offset = (page - 1) * limit;

    let query = `
      SELECT DISTINCT w.*, 
             CASE 
               WHEN $1::decimal IS NOT NULL AND $2::decimal IS NOT NULL THEN
                 (6371 * acos(cos(radians($1)) * cos(radians(w.latitude)) * 
                 cos(radians(w.longitude) - radians($2)) + sin(radians($1)) * 
                 sin(radians(w.latitude))))
               ELSE NULL 
             END as distance
      FROM workshops w
      LEFT JOIN services s ON w.id = s.workshop_id
      LEFT JOIN service_category_relations scr ON s.id = scr.service_id
      LEFT JOIN service_categories sc ON scr.category_id = sc.id
      WHERE w.is_verified = true
    `;

    const params = [lat, lng];
    let paramIndex = 3;

    // Filtro por categoría
    if (category) {
      query += ` AND sc.name ILIKE $${paramIndex}`;
      params.push(`%${category}%`);
      paramIndex++;
    }

    // Filtro por distancia
    if (lat && lng) {
      query += ` AND (6371 * acos(cos(radians($1)) * cos(radians(w.latitude)) * 
                 cos(radians(w.longitude) - radians($2)) + sin(radians($1)) * 
                 sin(radians(w.latitude)))) <= $${paramIndex}`;
      params.push(radius);
      paramIndex++;
    }

    query += ` ORDER BY w.rating DESC, distance ASC NULLS LAST LIMIT $${paramIndex} OFFSET $${paramIndex + 1}`;
    params.push(limit, offset);

    const result = await db.query(query, params);

    // Obtener servicios para cada taller
    const workshopsWithServices = await Promise.all(
      result.rows.map(async (workshop) => {
        const servicesResult = await db.query(
          `SELECT s.*, sc.name as category_name 
           FROM services s
           LEFT JOIN service_category_relations scr ON s.id = scr.service_id
           LEFT JOIN service_categories sc ON scr.category_id = sc.id
           WHERE s.workshop_id = $1 AND s.is_active = true`,
          [workshop.id]
        );
        
        return {
          ...workshop,
          services: servicesResult.rows,
          distance: workshop.distance ? parseFloat(workshop.distance).toFixed(2) : null
        };
      })
    );

    res.json({
      workshops: workshopsWithServices,
      pagination: {
        page: parseInt(page),
        limit: parseInt(limit),
        total: result.rows.length
      }
    });
  } catch (error) {
    console.error('Error buscando talleres:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Obtener detalles de un taller
router.get('/:id', async (req, res) => {
  try {
    const { id } = req.params;

    const workshopResult = await db.query(
      'SELECT * FROM workshops WHERE id = $1 AND is_verified = true',
      [id]
    );

    if (workshopResult.rows.length === 0) {
      return res.status(404).json({ error: 'Taller no encontrado' });
    }

    const workshop = workshopResult.rows[0];

    // Obtener servicios
    const servicesResult = await db.query(
      `SELECT s.*, sc.name as category_name 
       FROM services s
       LEFT JOIN service_category_relations scr ON s.id = scr.service_id
       LEFT JOIN service_categories sc ON scr.category_id = sc.id
       WHERE s.workshop_id = $1 AND s.is_active = true`,
      [id]
    );

    // Obtener reseñas recientes
    const reviewsResult = await db.query(
      `SELECT r.*, u.first_name, u.last_name 
       FROM reviews r
       JOIN users u ON r.client_id = u.id
       WHERE r.workshop_id = $1
       ORDER BY r.created_at DESC LIMIT 10`,
      [id]
    );

    res.json({
      ...workshop,
      services: servicesResult.rows,
      reviews: reviewsResult.rows
    });
  } catch (error) {
    console.error('Error obteniendo taller:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

// Crear/actualizar perfil de taller (solo para usuarios workshop)
router.post('/profile', authenticateToken, authorizeRoles('workshop'), [
  body('businessName').trim().isLength({ min: 2 }),
  body('address').trim().isLength({ min: 5 }),
  body('latitude').isFloat({ min: -90, max: 90 }),
  body('longitude').isFloat({ min: -180, max: 180 }),
  body('phone').optional().isMobilePhone()
], async (req, res) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const {
      businessName,
      description,
      address,
      latitude,
      longitude,
      phone,
      email,
      website,
      businessHours
    } = req.body;

    // Verificar si ya existe un perfil
    const existingWorkshop = await db.query(
      'SELECT id FROM workshops WHERE user_id = $1',
      [req.user.id]
    );

    let result;
    if (existingWorkshop.rows.length > 0) {
      // Actualizar
      result = await db.query(
        `UPDATE workshops SET 
         business_name = $1, description = $2, address = $3, 
         latitude = $4, longitude = $5, phone = $6, email = $7, 
         website = $8, business_hours = $9, updated_at = CURRENT_TIMESTAMP
         WHERE user_id = $10 RETURNING *`,
        [businessName, description, address, latitude, longitude, phone, email, website, businessHours, req.user.id]
      );
    } else {
      // Crear nuevo
      result = await db.query(
        `INSERT INTO workshops 
         (user_id, business_name, description, address, latitude, longitude, phone, email, website, business_hours)
         VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10) RETURNING *`,
        [req.user.id, businessName, description, address, latitude, longitude, phone, email, website, businessHours]
      );
    }

    res.json({
      message: 'Perfil de taller actualizado exitosamente',
      workshop: result.rows[0]
    });
  } catch (error) {
    console.error('Error actualizando perfil:', error);
    res.status(500).json({ error: 'Error interno del servidor' });
  }
});

module.exports = router;