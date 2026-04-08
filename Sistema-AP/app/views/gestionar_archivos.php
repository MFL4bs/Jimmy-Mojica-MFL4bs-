<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Archivos - Sistema de Aprendizaje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-graduation-cap me-2"></i>
                Sistema de Aprendizaje
            </a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="text-white fw-bold mb-3">
                        <i class="fas fa-upload me-3"></i>Gestión de Archivos
                    </h1>
                    <p class="text-white-50">Sube materiales para el curso: <strong><?php echo htmlspecialchars($curso['titulo']); ?></strong></p>
                </div>
                
                <!-- Form Card -->
                <div class="card dashboard-card border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-cloud-upload-alt me-2 text-primary"></i>Subir Archivo
                        </h5>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Seleccionar archivo</label>
                                <input type="file" name="archivo" class="form-control" required 
                                       accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.png,.mp4,.zip">
                                <div class="form-text">Formatos permitidos: PDF, DOC, PPT, imágenes, videos, ZIP</div>
                            </div>
                            
                            <button type="submit" class="btn btn-gradient">
                                <i class="fas fa-upload me-2"></i>Subir Archivo
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Archivos Existentes -->
                <div class="card dashboard-card border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-folder me-2 text-primary"></i>Archivos del Curso
                        </h5>
                        
                        <?php if(!empty($archivos)): ?>
                            <div class="list-group">
                                <?php foreach($archivos as $archivo): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file me-3 text-muted"></i>
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($archivo['nombre_archivo']); ?></h6>
                                                <small class="text-muted">
                                                    Subido: <?php echo date('d/m/Y H:i', strtotime($archivo['fecha_subida'])); ?>
                                                    | Tamaño: <?php echo round($archivo['tamaño_archivo']/1024, 2); ?> KB
                                                </small>
                                            </div>
                                        </div>
                                        <a href="../public/<?php echo $archivo['ruta_archivo']; ?>" 
                                           class="btn btn-outline-primary btn-sm" target="_blank">
                                            <i class="fas fa-download me-1"></i>Descargar
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay archivos subidos para este curso</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>