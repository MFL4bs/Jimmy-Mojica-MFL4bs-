<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: drive.php');
    exit;
}

// Prevenir cache del navegador
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Drive - Acceso</title>
    <link rel="icon" type="image/png" href="MF_LABS_logo-removebg-preview.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gradient">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <!-- Login Form -->
                <div id="loginForm" class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="MF_LABS_logo-removebg-preview.png" alt="Logo" class="mb-3" style="height: 60px;">
                            <h2 class="fw-bold text-dark mb-0">Bienvenido de vuelta</h2>
                            <p class="text-muted">Accede a tu drive personal</p>
                        </div>
                        <form>
                            <div class="mb-3">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Usuario" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 rounded-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar a mi Drive
                            </button>
                        </form>
                        <div class="text-center">
                            <span class="text-muted">¿Primera vez aquí?</span>
                            <a href="#" onclick="drive.showRegister()" class="text-decoration-none fw-semibold">Crear cuenta</a>
                        </div>
                    </div>
                </div>

                <!-- Register Form -->
                <div id="registerForm" class="card shadow-lg border-0 rounded-4 d-none">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="MF_LABS_logo-removebg-preview.png" alt="Logo" class="mb-3" style="height: 60px;">
                            <h2 class="fw-bold text-dark mb-0">Crear tu Drive</h2>
                            <p class="text-muted">Únete y comienza a almacenar</p>
                        </div>
                        <form>
                            <div class="mb-3">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-plus"></i></span>
                                    <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Elige un usuario" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="Tu email" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Contraseña segura" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Almacenamiento necesario</label>
                                <select name="storage_plan" class="form-select form-select-lg" required>
                                    <option value="5">5 GB - Gratis</option>
                                    <option value="25">25 GB - $5/mes</option>
                                    <option value="100">100 GB - $15/mes</option>
                                    <option value="500">500 GB - $50/mes</option>
                                    <option value="1000">1 TB - $100/mes</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg w-100 mb-3 rounded-3">
                                <i class="bi bi-rocket-takeoff me-2"></i>Crear mi cuenta
                            </button>
                        </form>
                        <div class="text-center">
                            <span class="text-muted">¿Ya tienes cuenta?</span>
                            <a href="#" onclick="drive.showLogin()" class="text-decoration-none fw-semibold">Iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Prevenir navegación hacia atrás desde drive.php
        if (document.referrer.includes('drive.php')) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, null, window.location.href);
            };
        }
    </script>
    <script src="assets/js/app.js"></script>
</body>
</html>