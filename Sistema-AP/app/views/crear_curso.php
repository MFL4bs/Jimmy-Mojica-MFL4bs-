<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso - Sistema de Aprendizaje</title>
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
                            <i class="fas fa-book me-1"></i>Ver Cursos
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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="text-white fw-bold mb-3">
                        <i class="fas fa-plus-circle me-3"></i>Crear Nuevo Curso
                    </h1>
                    <p class="text-white-50">Comparte tu conocimiento y ayuda a otros a aprender</p>
                </div>
                
                <!-- Form Card -->
                <div class="card dashboard-card border-0">
                    <div class="card-body p-5">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-heading me-2 text-primary"></i>Título del curso
                                </label>
                                <input type="text" name="titulo" class="form-control form-control-lg" 
                                       placeholder="Ej: Introducción a JavaScript" required>
                                <div class="form-text">Elige un título claro y descriptivo</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Descripción del curso
                                </label>
                                <textarea name="descripcion" class="form-control" rows="6" 
                                          placeholder="Describe qué aprenderán los estudiantes, qué temas cubrirás y qué requisitos previos necesitan..." 
                                          required></textarea>
                                <div class="form-text">Proporciona una descripción detallada del contenido</div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="cursos.php" class="btn btn-outline-secondary btn-lg me-md-2">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-gradient btn-lg px-5">
                                    <i class="fas fa-save me-2"></i>Crear Curso
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Tips Card -->
                <div class="card dashboard-card border-0 mt-4">
                    <div class="card-body p-4">
                        <h5 class="card-title text-primary mb-3">
                            <i class="fas fa-lightbulb me-2"></i>Consejos para crear un buen curso
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Usa un título claro y específico</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Describe los objetivos de aprendizaje</small>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Menciona los requisitos previos</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Explica qué incluye el curso</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>