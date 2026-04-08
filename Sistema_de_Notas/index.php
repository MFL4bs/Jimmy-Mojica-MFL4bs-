<?php
require_once 'config/database.php';
require_once 'app/controllers/Router.php';

session_start();

// Verificar si hay sesión activa
if (!isset($_GET['controller']) && isset($_SESSION['rol'])) {
    switch ($_SESSION['rol']) {
        case 'administrador':
            header('Location: ?controller=admin');
            break;
        case 'docente':
            header('Location: ?controller=docente');
            break;
        case 'estudiante':
            header('Location: ?controller=estudiante');
            break;
    }
    exit();
}

// Si no hay sesión, redirigir al login
if (!isset($_GET['controller']) && !isset($_SESSION['rol'])) {
    header('Location: ?controller=auth&action=login');
    exit();
}

$router = new Router();
$router->route();
?>