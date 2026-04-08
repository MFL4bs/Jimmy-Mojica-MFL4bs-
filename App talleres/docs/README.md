# Aplicación B2B2C Talleres Automotrices

## Descripción del Proyecto

Aplicación móvil híbrida que conecta talleres automotrices con clientes finales, permitiendo la gestión de citas, búsqueda de servicios por ubicación y sistema de calificaciones.

## Arquitectura del Sistema

### Stack Tecnológico

**Backend:**
- Node.js + Express.js
- PostgreSQL con índices optimizados
- JWT para autenticación
- Firebase para notificaciones push
- Redis para cache (opcional)

**Frontend Móvil:**
- Flutter 3.10+
- Provider para gestión de estado
- Google Maps para geolocalización
- Firebase Messaging

**Servicios Externos:**
- Google Maps API
- Firebase Authentication
- SendGrid para emails
- AWS S3 para almacenamiento

## Funcionalidades Principales

### Para Clientes
- ✅ Registro y autenticación (email, Google, Apple)
- ✅ Búsqueda de talleres por ubicación y filtros
- ✅ Visualización de servicios y precios
- ✅ Agendamiento de citas
- ✅ Seguimiento de estado de citas
- ✅ Sistema de calificaciones y reseñas
- ✅ Notificaciones push y email

### Para Talleres
- ✅ Panel de gestión de perfil de negocio
- ✅ Administración de servicios y precios
- ✅ Gestión de agenda de citas
- ✅ Actualización de estados de servicio
- ✅ Visualización de reseñas de clientes

### Para Administradores
- ✅ Gestión de usuarios y talleres
- ✅ Verificación de talleres
- ✅ Métricas y reportes básicos
- ✅ Gestión de categorías de servicios

## Estructura de Base de Datos

### Tablas Principales
- `users` - Usuarios del sistema (clientes, talleres, admins)
- `workshops` - Información de talleres
- `services` - Servicios ofrecidos por talleres
- `appointments` - Citas agendadas
- `reviews` - Calificaciones y reseñas
- `notifications` - Sistema de notificaciones

### Índices Optimizados
- Geolocalización (lat/lng) para búsquedas por proximidad
- Fechas de citas para consultas de agenda
- Estados de citas para filtros
- Relaciones usuario-taller para permisos

## API REST Endpoints

### Autenticación
- `POST /api/auth/register` - Registro de usuario
- `POST /api/auth/login` - Inicio de sesión
- `GET /api/auth/verify` - Verificación de token

### Talleres
- `GET /api/workshops/search` - Búsqueda con filtros y geolocalización
- `GET /api/workshops/:id` - Detalles de taller
- `POST /api/workshops/profile` - Crear/actualizar perfil

### Citas
- `POST /api/appointments` - Crear nueva cita
- `GET /api/appointments/my-appointments` - Listar citas del usuario
- `PATCH /api/appointments/:id/status` - Actualizar estado (talleres)
- `PATCH /api/appointments/:id/cancel` - Cancelar cita (clientes)

### Usuarios
- `GET /api/users/profile` - Obtener perfil
- `PUT /api/users/profile` - Actualizar perfil
- `GET /api/users/notifications` - Obtener notificaciones
- `POST /api/users/reviews` - Crear reseña

## Configuración del Entorno

### Backend
1. Instalar dependencias: `npm install`
2. Configurar variables de entorno (`.env`)
3. Crear base de datos PostgreSQL
4. Ejecutar scripts de migración
5. Iniciar servidor: `npm run dev`

### Mobile App
1. Instalar Flutter SDK
2. Configurar Firebase
3. Instalar dependencias: `flutter pub get`
4. Configurar Google Maps API
5. Ejecutar app: `flutter run`

## Seguridad Implementada

- ✅ Autenticación JWT con expiración
- ✅ Validación de entrada en todas las rutas
- ✅ Rate limiting para prevenir ataques
- ✅ Helmet.js para headers de seguridad
- ✅ Bcrypt para hash de contraseñas
- ✅ Autorización basada en roles
- ✅ Sanitización de datos de entrada

## Características de Rendimiento

- ✅ Índices de base de datos optimizados
- ✅ Paginación en listados
- ✅ Cache de imágenes en app móvil
- ✅ Lazy loading de componentes
- ✅ Compresión de respuestas API

## Próximas Fases (Roadmap)

### Fase 2 - Pagos
- Integración con Stripe/PayPal
- Pagos en línea para servicios
- Facturación automática

### Fase 3 - Funcionalidades Avanzadas
- Chat en tiempo real
- Historial de vehículos
- Recordatorios de mantenimiento
- Sistema de promociones

### Fase 4 - Analytics y BI
- Dashboard de métricas avanzadas
- Reportes de negocio
- Análisis de comportamiento de usuarios

## Estimación de Tiempos

- **Prototipo Figma:** 2 semanas
- **Backend API:** 4 semanas
- **App Móvil:** 6 semanas
- **Testing y QA:** 2 semanas
- **Despliegue:** 1 semana

**Total estimado:** 15 semanas

## Entregables

1. ✅ Código fuente completo (Backend + Mobile)
2. ✅ Base de datos estructurada con scripts
3. ✅ Documentación técnica
4. 🔄 Prototipo navegable en Figma
5. 🔄 Manual de despliegue
6. 🔄 Soporte post-lanzamiento (1 mes)

## Tecnologías de Despliegue

**Backend:**
- AWS EC2 / DigitalOcean
- PostgreSQL en RDS / managed database
- Redis para cache
- Load balancer para escalabilidad

**Mobile:**
- Google Play Store
- Apple App Store
- Firebase Hosting para assets

## Contacto y Soporte

Para consultas técnicas o soporte durante el desarrollo, contactar al equipo de desarrollo con la documentación de APIs y guías de configuración incluidas en este repositorio.