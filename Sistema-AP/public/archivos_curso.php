<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../app/controllers/MisCursosController.php';
require_once '../config/database.php';

$curso_id = $_GET['curso_id'] ?? 0;

// Verificar que el usuario esté matriculado en el curso
$database = new Database();
$db = $database->getConnection();
$query = "SELECT c.titulo, c.descripcion, u.nombre as instructor 
          FROM cursos c 
          INNER JOIN inscripciones i ON c.id = i.curso_id
          INNER JOIN usuarios u ON c.instructor_id = u.id
          WHERE c.id = ? AND i.usuario_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$curso_id, $_SESSION['usuario_id']]);
$curso = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$curso) {
    header("Location: mis_cursos.php");
    exit();
}

$controller = new MisCursosController();
$archivos = $controller->obtenerArchivosCurso($curso_id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales del Curso - Sistema de Aprendizaje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-graduation-cap me-2"></i>
                Sistema de Aprendizaje
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mis_cursos.php">
                            <i class="fas fa-arrow-left me-1"></i>Volver a Mis Cursos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5">
                    <h1 class="text-white fw-bold mb-3">
                        <i class="fas fa-folder-open me-3"></i>Materiales del Curso
                    </h1>
                    <p class="text-white-50"><?php echo htmlspecialchars($curso['titulo']); ?></p>
                </div>
                
                <div class="card dashboard-card border-0">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="card-title"><?php echo htmlspecialchars($curso['titulo']); ?></h5>
                            <p class="text-muted"><?php echo htmlspecialchars($curso['descripcion']); ?></p>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                Instructor: <?php echo htmlspecialchars($curso['instructor']); ?>
                            </small>
                        </div>
                        
                        <h6 class="mb-3">
                            <i class="fas fa-download me-2 text-primary"></i>Archivos Disponibles
                        </h6>
                        
                        <?php if(!empty($archivos)): ?>
                            <div class="list-group">
                                <?php foreach($archivos as $archivo): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file me-3 text-muted"></i>
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($archivo['nombre_archivo']); ?></h6>
                                                <small class="text-muted">
                                                    <?php echo date('d/m/Y H:i', strtotime($archivo['fecha_subida'])); ?>
                                                    | <?php echo round($archivo['tamaño_archivo']/1024, 2); ?> KB
                                                </small>
                                            </div>
                                        </div>
                                        <a href="<?php echo $archivo['ruta_archivo']; ?>" 
                                           class="btn btn-primary btn-sm" target="_blank">
                                            <i class="fas fa-download me-1"></i>Descargar
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay materiales disponibles para este curso</p>
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