<?php
require_once 'BaseController.php';
require_once 'app/models/Usuario.php';
require_once 'app/models/Estudiante.php';
require_once 'app/models/Materia.php';

class AdminController extends BaseController {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: ?controller=auth&action=login');
            exit();
        }
    }
    
    public function index() {
        $data = [
            'title' => 'Panel de Administrador',
            'username' => $_SESSION['username']
        ];
        $this->view('admin/dashboard', $data);
    }
}
?>