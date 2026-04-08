<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../app/controllers/CursoController.php';

$controller = new CursoController();
$controller->index();
?>