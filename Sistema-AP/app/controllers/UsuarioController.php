<?php
require_once '../config/database.php';
require_once '../app/models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function login() {
        if($_POST) {
            $this->usuario->email = $_POST['email'];
            $this->usuario->password = $_POST['password'];
            
            if($this->usuario->login()) {
                session_start();
                $_SESSION['usuario_id'] = $this->usuario->id;
                $_SESSION['usuario_nombre'] = $this->usuario->nombre;
                $_SESSION['usuario_tipo'] = $this->usuario->tipo;
                $_SESSION['login_success'] = true;
                header("Location: dashboard.php");
            } else {
                $error = "Credenciales incorrectas";
                include '../app/views/login.php';
            }
        } else {
            include '../app/views/login.php';
        }
    }

    public function registro() {
        if($_POST) {
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->email = $_POST['email'];
            $this->usuario->password = $_POST['password'];
            $this->usuario->tipo = 'estudiante';
            
            if($this->usuario->crear()) {
                $_SESSION['registro_success'] = true;
                header("Location: login.php");
            } else {
                $error = "Error al registrar usuario";
                include '../app/views/registro.php';
            }
        } else {
            include '../app/views/registro.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: login.php");
    }
}
?>