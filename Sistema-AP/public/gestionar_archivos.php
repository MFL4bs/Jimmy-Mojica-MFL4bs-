<?php
session_start();
if(!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

require_once '../app/controllers/ArchivoController.php';
require_once '../config/database.php';

$curso_id = $_GET['curso_id'] ?? 0;

// Obtener información del curso
$database = new Database();
$db = $database->getConnection();
$query = "SELECT titulo FROM cursos WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$curso_id]);
$curso = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$curso) {
    header("Location: cursos.php");
    exit();
}

$controller = new ArchivoController();

// Procesar subida de archivo
if($_POST && isset($_FILES['archivo'])) {
    if($controller->subirArchivo($curso_id, $_FILES['archivo'])) {
        $_SESSION['archivo_success'] = true;
        header("Location: gestionar_archivos.php?curso_id=" . $curso_id);
        exit();
    } else {
        $error = "Error al subir el archivo";
    }
}

$archivos = $controller->obtenerArchivosCurso($curso_id);
include '../app/views/gestionar_archivos.php';
?>