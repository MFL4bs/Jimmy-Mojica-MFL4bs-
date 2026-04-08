<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Solo instructores y admin pueden crear cursos
if($_SESSION['usuario_tipo'] != 'instructor' && $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: cursos.php");
    exit();
}

require_once '../app/controllers/CursoController.php';

$controller = new CursoController();
$controller->crear();
?>