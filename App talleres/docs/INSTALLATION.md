# Guía de Instalación y Configuración

## Requisitos del Sistema

### Backend
- Node.js 18+ 
- PostgreSQL 13+
- Redis (opcional, para cache)
- Git

### Mobile App
- Flutter SDK 3.10+
- Android Studio / Xcode
- Firebase CLI

## Configuración del Backend

### 1. Instalación de Dependencias

```bash
cd backend
npm install
```

### 2. Configuración de Base de Datos

```bash
# Crear base de datos PostgreSQL
createdb talleres_app

# Ejecutar schema
psql -d talleres_app -f ../database/schema.sql
```

### 3. Variables de Entorno

Copiar `.env.example` a `.env` y configurar:

```env
NODE_ENV=development
PORT=3000
DB_HOST=localhost
DB_NAME=talleres_app
DB_USER=postgres
DB_PASSWORD=tu_password
JWT_SECRET=tu_jwt_secret_muy_seguro
```

### 4. Iniciar Servidor

```bash
npm run dev
```

El servidor estará disponible en `http://localhost:3000`

## Configuración de la App Móvil

### 1. Instalación de Flutter

```bash
# Verificar instalación
flutter doctor

# Instalar dependencias
cd mobile_app
flutter pub get
```

### 2. Configuración de Firebase

1. Crear proyecto en Firebase Console
2. Agregar apps Android e iOS
3. Descargar `google-services.json` y `GoogleService-Info.plist`
4. Colocar archivos en las carpetas correspondientes

### 3. Configuración de Google Maps

1. Obtener API Key de Google Cloud Console
2. Habilitar Maps SDK para Android/iOS
3. Configurar en `android/app/src/main/AndroidManifest.xml`:

```xml
<meta-data
    android:name="com.google.android.geo.API_KEY"
    android:value="TU_API_KEY"/>
```

### 4. Ejecutar App

```bash
# Android
flutter run

# iOS (requiere macOS)
flutter run -d ios
```

## Configuración de Servicios Externos

### Firebase Authentication

1. Habilitar proveedores de autenticación:
   - Email/Password
   - Google
   - Apple (iOS)

2. Configurar dominios autorizados

### SendGrid (Emails)

1. Crear cuenta en SendGrid
2. Obtener API Key
3. Configurar sender identity

### AWS S3 (Almacenamiento)

1. Crear bucket S3
2. Configurar políticas de acceso
3. Obtener credenciales IAM

## Scripts de Base de Datos

### Datos de Prueba

```sql
-- Insertar categorías de servicios
INSERT INTO service_categories (name, icon) VALUES
('Mecánica General', 'build'),
('Electricidad', 'electrical_services'),
('Frenos', 'car_repair'),
('Neumáticos', 'tire_repair'),
('Aire Acondicionado', 'ac_unit');

-- Usuario de prueba (taller)
INSERT INTO users (email, password_hash, first_name, last_name, role) VALUES
('taller@test.com', '$2a$12$hash_aqui', 'Taller', 'Ejemplo', 'workshop');
```

## Despliegue en Producción

### Backend (AWS EC2)

```bash
# Instalar PM2 para gestión de procesos
npm install -g pm2

# Configurar variables de producción
export NODE_ENV=production

# Iniciar con PM2
pm2 start server.js --name talleres-api
```

### Base de Datos (AWS RDS)

1. Crear instancia PostgreSQL en RDS
2. Configurar security groups
3. Ejecutar migraciones

### App Móvil

#### Android (Google Play)

```bash
# Generar APK de release
flutter build apk --release

# O generar App Bundle
flutter build appbundle --release
```

#### iOS (App Store)

```bash
# Generar build para iOS
flutter build ios --release
```

## Monitoreo y Logs

### Backend

```bash
# Ver logs con PM2
pm2 logs talleres-api

# Monitoreo en tiempo real
pm2 monit
```

### Base de Datos

```sql
-- Consultas de monitoreo
SELECT * FROM pg_stat_activity;
SELECT * FROM pg_stat_user_tables;
```

## Troubleshooting

### Problemas Comunes

1. **Error de conexión a BD:**
   - Verificar credenciales en `.env`
   - Confirmar que PostgreSQL esté ejecutándose

2. **Flutter build fails:**
   - Ejecutar `flutter clean`
   - Verificar versiones de dependencias

3. **Google Maps no carga:**
   - Verificar API Key
   - Confirmar que Maps SDK esté habilitado

### Logs Útiles

```bash
# Backend logs
tail -f logs/app.log

# Flutter logs
flutter logs
```

## Backup y Restauración

### Base de Datos

```bash
# Backup
pg_dump talleres_app > backup.sql

# Restauración
psql talleres_app < backup.sql
```

### Archivos de Configuración

Mantener respaldos de:
- `.env` (sin credenciales sensibles)
- Certificados Firebase
- Configuraciones de despliegue

## Contacto de Soporte

Para asistencia técnica durante la configuración:
- Email: soporte@tuapp.com
- Documentación: `/docs`
- Issues: GitHub repository