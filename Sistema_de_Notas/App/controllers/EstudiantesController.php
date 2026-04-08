<?php
require_once 'BaseController.php';
require_once 'app/models/Estudiante.php';

class EstudiantesController extends BaseController {
    private $estudianteModel;
    
    public function __construct() {
        session_start();
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['administrador', 'docente'])) {
            header('Location: ?controller=auth&action=login');
            exit();
        }
        $this->estudianteModel = new Estudiante();
    }
    
    public function index() {
        $estudiantes = $this->estudianteModel->getAll();
        $data = [
            'title' => 'Estudiantes',
            'estudiantes' => $estudiantes
        ];
        $this->view('estudiantes/index', $data);
    }
    
    public function create() {
        if ($_POST) {
            $this->estudianteModel->create($_POST);
            $this->redirect('?controller=estudiantes');
        }
        $this->view('estudiantes/create', ['title' => 'Nuevo Estudiante']);
    }
}
?>