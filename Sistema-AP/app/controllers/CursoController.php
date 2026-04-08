<?php
require_once '../config/database.php';
require_once '../app/models/Curso.php';

class CursoController {
    private $db;
    private $curso;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->curso = new Curso($this->db);
    }

    public function index() {
        $stmt = $this->curso->obtenerTodos();
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include '../app/views/cursos.php';
    }

    public function crear() {
        session_start();
        if($_POST) {
            $this->curso->titulo = $_POST['titulo'];
            $this->curso->descripcion = $_POST['descripcion'];
            $this->curso->instructor_id = $_SESSION['usuario_id'];
            
            if($this->curso->crear()) {
                $_SESSION['curso_success'] = true;
                header("Location: cursos.php");
            } else {
                $error = "Error al crear curso";
                include '../app/views/crear_curso.php';
            }
        } else {
            include '../app/views/crear_curso.php';
        }
    }
}
?>