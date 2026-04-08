<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Aprendizaje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                Sistema de Aprendizaje
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo $_SESSION['usuario_nombre']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="mis_cursos.php"><i class="fas fa-bookmark me-2"></i>Mis Cursos</a></li>
                            <li><a class="dropdown-item" href="cursos.php"><i class="fas fa-book me-2"></i>Ver Cursos</a></li>
                            <?php if($_SESSION['usuario_tipo'] == 'instructor' || $_SESSION['usuario_tipo'] == 'admin'): ?>
                            <li><a class="dropdown-item" href="crear_curso.php"><i class="fas fa-plus me-2"></i>Crear Curso</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <div class="container mt-4">
        <div class="hero-section p-5 mb-5 text-white text-center">
            <h1 class="display-4 fw-bold mb-3">
                ¡Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?>!
            </h1>
            <p class="lead mb-4">Explora, aprende y crea cursos increíbles en nuestra plataforma</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="mis_cursos.php" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-bookmark me-2"></i>Mis Cursos
                </a>
                <a href="cursos.php" class="btn btn-outline-light btn-lg px-4">
                    <i class="fas fa-search me-2"></i>Explorar Cursos
                </a>
                <?php if($_SESSION['usuario_tipo'] == 'instructor' || $_SESSION['usuario_tipo'] == 'admin'): ?>
                <a href="crear_curso.php" class="btn btn-outline-light btn-lg px-4">
                    <i class="fas fa-plus me-2"></i>Crear Curso
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="card stats-card border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x mb-3"></i>
                        <h3 class="fw-bold">Mis Cursos</h3>
                        <p class="mb-0">Gestiona tus cursos inscritos</p>
                    </div>
                </div>
            </div>
            <?php if($_SESSION['usuario_tipo'] == 'instructor' || $_SESSION['usuario_tipo'] == 'admin'): ?>
            <div class="col-md-4 mb-3">
                <div class="card stats-card border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                        <h3 class="fw-bold">Enseñar</h3>
                        <p class="mb-0">Crea y comparte conocimiento</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-4 mb-3">
                <div class="card stats-card border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-trophy fa-3x mb-3"></i>
                        <h3 class="fw-bold">Logros</h3>
                        <p class="mb-0">Sigue tu progreso</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-gradient rounded-circle p-3 me-3">
                                <i class="fas fa-bookmark text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Mis Cursos</h5>
                                <p class="text-muted mb-0">Ve tus cursos matriculados</p>
                            </div>
                        </div>
                        <a href="mis_cursos.php" class="btn btn-gradient w-100">
                            <i class="fas fa-bookmark me-2"></i>Ver Mis Cursos
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
                                <i class="fas fa-book text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Explorar Cursos</h5>
                                <p class="text-muted mb-0">Descubre nuevos cursos disponibles</p>
                            </div>
                        </div>
                        <a href="cursos.php" class="btn btn-gradient w-100">
                            <i class="fas fa-arrow-right me-2"></i>Ver Todos los Cursos
                        </a>
                    </div>
                </div>
            </div>
            
            <?php if($_SESSION['usuario_tipo'] == 'instructor' || $_SESSION['usuario_tipo'] == 'admin'): ?>
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-gradient rounded-circle p-3 me-3">
                                <i class="fas fa-plus text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Crear Curso</h5>
                                <p class="text-muted mb-0">Comparte tu conocimiento con otros</p>
                            </div>
                        </div>
                        <a href="crear_curso.php" class="btn btn-gradient w-100">
                            <i class="fas fa-plus me-2"></i>Crear Nuevo Curso
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if(isset($_SESSION['login_success'])): ?>
    <script>
        Swal.fire('¡Bienvenido!', 'Has iniciado sesión correctamente', 'success');
    </script>
    <?php unset($_SESSION['login_success']); endif; ?>
</body>
</html>