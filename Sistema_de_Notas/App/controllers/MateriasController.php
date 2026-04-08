<?php
require_once 'BaseController.php';
require_once 'app/models/Materia.php';

class MateriasController extends BaseController {
    private $materiaModel;
    
    public function __construct() {
        session_start();
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['administrador', 'docente'])) {
            header('Location: ?controller=auth&action=login');
            exit();
        }
        $this->materiaModel = new Materia();
    }
    
    public function index() {
        $materias = $this->materiaModel->getAll();
        $data = [
            'title' => 'Materias',
            'materias' => $materias
        ];
        $this->view('materias/index', $data);
    }
    
    public function create() {
        if ($_POST) {
            $this->materiaModel->create($_POST);
            $this->redirect('?controller=materias');
        }
        $this->view('materias/create', ['title' => 'Nueva Materia']);
    }
}
?>