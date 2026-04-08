<?php
session_start();
require_once '../models/User.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $action = $_POST['action'];
        $user = new User();
        
        if ($action == 'register') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $storage_plan = intval($_POST['storage_plan']);
            
            if ($user->userExists($username, $email)) {
                echo json_encode(['success' => false, 'message' => 'Usuario o email ya existe']);
            } else {
                if ($user->register($username, $email, $password, $storage_plan)) {
                    echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
                }
            }
        }
        
        if ($action == 'login') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            $userData = $user->login($username, $password);
            if ($userData) {
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['username'] = $userData['username'];
                echo json_encode(['success' => true, 'message' => 'Login exitoso']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas']);
            }
        }
        
        if ($action == 'logout') {
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'Sesión cerrada']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>