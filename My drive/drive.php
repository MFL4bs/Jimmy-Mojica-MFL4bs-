<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
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
    <title>📁 Mi Drive Personal</title>
    <link rel="icon" type="image/png" href="MF_LABS_logo-removebg-preview.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="MF_LABS_logo-removebg-preview.png" alt="Logo" height="40" class="me-3">
                <div>
                    <span class="navbar-brand mb-0 h1"><i class="bi bi-cloud-fill me-2"></i>Mi Drive Personal</span>
                    <small class="d-block text-muted">Tu espacio personal en la nube</small>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Configuración</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button id="logoutBtn" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-3">ACCIONES RÁPIDAS</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                                <i class="bi bi-cloud-upload me-2"></i>Subir Archivo
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-folder-plus me-2"></i>Nueva Carpeta
                            </button>
                        </div>
                        <hr>
                        <h6 class="text-muted mb-3">ALMACENAMIENTO</h6>
                        <div class="progress mb-2" style="height: 8px;" id="storageProgress">
                            <div class="progress-bar bg-primary" style="width: 0%"></div>
                        </div>
                        <small class="text-muted" id="storageText">Cargando...</small>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <!-- Upload Area -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div id="uploadArea" class="upload-zone text-center p-5 border-2 border-dashed rounded-3">
                            <i class="bi bi-cloud-upload display-1 text-primary mb-3"></i>
                            <h5 class="mb-2">Arrastra archivos aquí</h5>
                            <p class="text-muted mb-3">o haz clic para seleccionar archivos</p>
                            <button class="btn btn-outline-primary" onclick="document.getElementById('fileInput').click()">
                                <i class="bi bi-file-earmark-plus me-2"></i>Seleccionar Archivos
                            </button>
                            <input type="file" id="fileInput" class="d-none" multiple>
                        </div>
                    </div>
                </div>

                <!-- Files Section -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-files me-2"></i>Mis Archivos</h5>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm active">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="filesGrid" class="row g-3">
                            <!-- Files will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Prevenir navegación hacia atrás
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, null, window.location.href);
        };
        
        // Cerrar sesión al salir de la página
        window.addEventListener('beforeunload', function() {
            navigator.sendBeacon('controllers/auth.php', new URLSearchParams({action: 'logout'}));
        });
    </script>
    <script src="assets/js/app.js"></script>
</body>
</html>