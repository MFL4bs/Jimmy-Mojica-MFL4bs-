<?php
require_once 'BaseController.php';
require_once 'app/models/Nota.php';

class DocenteController extends BaseController {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'docente') {
            header('Location: ?controller=auth&action=login');
            exit();
        }
    }
    
    public function index() {
        $data = [
            'title' => 'Panel de Docente',
            'username' => $_SESSION['username']
        ];
        $this->view('docente/dashboard', $data);
    }
}
?>