@echo off
echo ========================================
echo    TALLERES APP - INICIO AUTOMATICO
echo ========================================
echo.

echo Verificando Node.js...
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Node.js no encontrado
    echo Descarga desde: https://nodejs.org
    pause
    exit /b 1
)

echo Verificando Flutter...
flutter --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Flutter no encontrado
    echo Descarga desde: https://flutter.dev
    pause
    exit /b 1
)

echo.
echo Iniciando Backend...
cd backend
start "Backend API" cmd /k "npm install && npm run dev"

echo.
echo Iniciando App Movil...
cd ..\mobile_app
start "Flutter App" cmd /k "flutter pub get && flutter run"

echo.
echo ========================================
echo Aplicacion iniciada exitosamente!
echo Backend: http://localhost:3000
echo App: Emulador Android/iOS
echo ========================================
pause