<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos - Sistema de Aprendizaje</title>
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
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cursos.php">
                            <i class="fas fa-search me-1"></i>Explorar Cursos
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
        <!-- Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="text-white fw-bold mb-2">
                    <i class="fas fa-bookmark me-3"></i>Mis Cursos
                </h1>
                <p class="text-white-50 mb-0">Cursos en los que estás matriculado</p>
            </div>
        </div>
        
        <!-- Cursos Matriculados -->
        <div class="row">
            <?php if(!empty($cursos)): ?>
                <?php foreach($cursos as $curso): ?>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="card curso-card h-100 border-0">
                            <div class="card-header text-center py-3">
                                <i class="fas fa-book-open fa-2x mb-2"></i>
                                <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($curso['titulo']); ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-muted mb-3">
                                    <?php echo htmlspecialchars($curso['descripcion']); ?>
                                </p>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-2">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <small class="text-muted">
                                        <strong>Instructor:</strong> <?php echo htmlspecialchars($curso['instructor']); ?>
                                    </small>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-2">
                                        <i class="fas fa-calendar text-muted"></i>
                                    </div>
                                    <small class="text-muted">
                                        <strong>Matriculado:</strong> <?php echo date('d/m/Y', strtotime($curso['fecha_inscripcion'])); ?>
                                    </small>
                                </div>
                                
                                <button onclick="verArchivos(<?php echo $curso['id']; ?>)" class="btn btn-gradient w-100">
                                    <i class="fas fa-folder-open me-2"></i>Ver Materiales
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="card dashboard-card border-0 mx-auto" style="max-width: 500px;">
                            <div class="card-body p-5">
                                <i class="fas fa-bookmark fa-4x text-muted mb-4"></i>
                                <h3 class="text-muted mb-3">No tienes cursos matriculados</h3>
                                <p class="text-muted mb-4">Explora nuestros cursos y matricúlate en uno</p>
                                <a href="cursos.php" class="btn btn-gradient btn-lg">
                                    <i class="fas fa-search me-2"></i>Explorar Cursos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verArchivos(cursoId) {
            window.location.href = 'archivos_curso.php?curso_id=' + cursoId;
        }
    </script>
</body>
</html>