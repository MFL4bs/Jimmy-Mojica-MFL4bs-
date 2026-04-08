<?php
require_once 'BaseController.php';
require_once 'app/models/Nota.php';

class EstudianteController extends BaseController {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'estudiante') {
            header('Location: ?controller=auth&action=login');
            exit();
        }
    }
    
    public function index() {
        $data = [
            'title' => 'Panel de Estudiante',
            'username' => $_SESSION['username']
        ];
        $this->view('estudiante/dashboard', $data);
    }
}
?>