<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - Sistema de Aprendizaje</title>
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
                    <?php if($_SESSION['usuario_tipo'] == 'instructor' || $_SESSION['usuario_tipo'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="crear_curso.php">
                            <i class="fas fa-plus me-1"></i>Crear Curso
                        </a>
                    </li>
                    <?php endif; ?>
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
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="text-white fw-bold mb-2">
                            <i class="fas fa-book me-3"></i>Cursos Disponibles
                        </h1>
                        <p class="text-white-50 mb-0">Explora y aprende con nuestros cursos</p>
                    </div>
                    <?php if($_SESSION['usuario_tipo'] == 'instructor' || $_SESSION['usuario_tipo'] == 'admin'): ?>
                    <a href="crear_curso.php" class="btn btn-light btn-lg">
                        <i class="fas fa-plus me-2"></i>Nuevo Curso
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Cursos Grid -->
        <div class="row">
            <?php foreach($cursos as $curso): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card curso-card h-100 border-0">
                        <div class="card-header text-center py-3">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($curso['titulo']); ?></h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text text-muted mb-3">
                                <?php echo htmlspecialchars($curso['descripcion']); ?>
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light rounded-circle p-2 me-2">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                    <small class="text-muted">
                                        <strong>Instructor:</strong> <?php echo htmlspecialchars($curso['instructor']); ?>
                                    </small>
                                </div>
                                
                                <button onclick="inscribirse(<?php echo $curso['id']; ?>)" 
                                        class="btn btn-gradient w-100 py-2 mb-2">
                                    <i class="fas fa-user-plus me-2"></i>Inscribirse
                                </button>
                                
                                <?php if($_SESSION['usuario_tipo'] == 'admin'): ?>
                                <a href="gestionar_archivos.php?curso_id=<?php echo $curso['id']; ?>" 
                                   class="btn btn-outline-primary w-100 py-2">
                                    <i class="fas fa-upload me-2"></i>Gestionar Archivos
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if(empty($cursos)): ?>
            <div class="text-center py-5">
                <div class="card dashboard-card border-0 mx-auto" style="max-width: 500px;">
                    <div class="card-body p-5">
                        <i class="fas fa-book fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">No hay cursos disponibles</h3>
                        <p class="text-muted mb-4">Sé el primero en crear un curso</p>
                        <a href="crear_curso.php" class="btn btn-gradient btn-lg">
                            <i class="fas fa-plus me-2"></i>Crear Primer Curso
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/app.js"></script>
    
    <?php if(isset($_SESSION['curso_success'])): ?>
    <script>
        Swal.fire('¡Éxito!', 'Curso creado correctamente', 'success');
    </script>
    <?php unset($_SESSION['curso_success']); endif; ?>
</body>
</html>