# Guía Rápida - Cómo Abrir la Aplicación

## Requisitos Previos
1. Node.js 18+ (descargar de nodejs.org)
2. PostgreSQL (descargar de postgresql.org)
3. Flutter SDK (descargar de flutter.dev)
4. Android Studio o VS Code

## Pasos para Ejecutar

### 1. Backend API
```bash
cd "c:\xampp\htdocs\App talleres\backend"
npm install
npm run dev
```

### 2. Base de Datos
```sql
-- Crear base de datos en PostgreSQL
CREATE DATABASE talleres_app;

-- Ejecutar schema
psql -d talleres_app -f "../database/schema.sql"
```

### 3. App Móvil (Flutter)
```bash
cd "c:\xampp\htdocs\App talleres\mobile_app"
flutter pub get
flutter run
```

## URLs de Acceso
- Backend API: http://localhost:3000
- App Móvil: Emulador Android/iOS

## Configuración Rápida
1. Copia `.env.example` a `.env` en backend/
2. Configura credenciales de PostgreSQL
3. Ejecuta los comandos arriba

## Problemas Comunes
- Si no tienes Node.js: Descargar de https://nodejs.org
- Si no tienes PostgreSQL: Usar XAMPP con MySQL como alternativa
- Si no tienes Flutter: Descargar de https://flutter.dev

## Demo Rápido (Sin Instalación)
Para ver el diseño sin instalar nada:
1. Abre los archivos .dart en VS Code
2. Revisa las pantallas en mobile_app/lib/screens/