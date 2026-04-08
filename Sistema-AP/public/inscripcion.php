<?php
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

require_once '../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $curso_id = $input['curso_id'];
    $usuario_id = $_SESSION['usuario_id'];
    
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "INSERT INTO inscripciones (usuario_id, curso_id) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    
    if($stmt->execute([$usuario_id, $curso_id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al inscribirse']);
    }
}
?>