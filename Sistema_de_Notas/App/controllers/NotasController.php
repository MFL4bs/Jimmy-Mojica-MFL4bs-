<?php
require_once 'BaseController.php';
require_once 'app/models/Nota.php';
require_once 'app/models/Estudiante.php';
require_once 'app/models/Materia.php';

class NotasController extends BaseController {
    private $notaModel;
    private $estudianteModel;
    private $materiaModel;
    
    public function __construct() {
        session_start();
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['administrador', 'docente'])) {
            header('Location: ?controller=auth&action=login');
            exit();
        }
        $this->notaModel = new Nota();
        $this->estudianteModel = new Estudiante();
        $this->materiaModel = new Materia();
    }
    
    public function index() {
        $notas = $this->notaModel->getAllWithDetails();
        $data = [
            'title' => 'Notas',
            'notas' => $notas
        ];
        $this->view('notas/index', $data);
    }
    
    public function create() {
        if ($_POST) {
            $this->notaModel->create($_POST);
            $this->redirect('?controller=notas');
        }
        
        $estudiantes = $this->estudianteModel->getAll();
        $materias = $this->materiaModel->getAll();
        
        $data = [
            'title' => 'Nueva Nota',
            'estudiantes' => $estudiantes,
            'materias' => $materias
        ];
        $this->view('notas/create', $data);
    }
}
?>