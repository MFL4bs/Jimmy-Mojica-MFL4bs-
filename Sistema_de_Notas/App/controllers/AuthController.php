<?php
require_once 'BaseController.php';
require_once 'app/models/Usuario.php';

class AuthController extends BaseController {
    private $usuarioModel;
    
    public function __construct() {
        $this->usuarioModel = new Usuario();
    }
    
    public function login() {
        if ($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $user = $this->usuarioModel->login($username, $password);
            
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['rol'] = $user['rol'];
                
                $this->redirectByRole($user['rol']);
            } else {
                $error = "Usuario o contraseña incorrectos";
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }
    
    public function logout() {
        session_start();
        session_destroy();
        $this->redirect('?controller=auth&action=login');
    }
    
    public function register() {
        session_start();
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            $this->redirect('?controller=auth&action=login');
        }
        
        if ($_POST) {
            if ($this->usuarioModel->existsUsername($_POST['username'])) {
                $error = "El nombre de usuario ya existe";
            } else {
                $this->usuarioModel->create($_POST);
                $success = "Usuario creado exitosamente";
            }
        }
        
        $data = [
            'title' => 'Registrar Usuario',
            'error' => $error ?? null,
            'success' => $success ?? null
        ];
        $this->view('auth/register', $data);
    }
    
    private function redirectByRole($rol) {
        switch ($rol) {
            case 'administrador':
                $this->redirect('?controller=admin');
                break;
            case 'docente':
                $this->redirect('?controller=docente');
                break;
            case 'estudiante':
                $this->redirect('?controller=estudiante');
                break;
        }
    }
}
?>