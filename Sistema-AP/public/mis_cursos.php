<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../app/controllers/MisCursosController.php';

$controller = new MisCursosController();
$cursos = $controller->obtenerCursosMatriculados($_SESSION['usuario_id']);

include '../app/views/mis_cursos.php';
?>