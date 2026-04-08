<?php
session_start();
require_once '../models/FileModel.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$fileModel = new FileModel();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    
    if ($action == 'upload') {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $upload_dir = '../uploads/';
            
            if ($file['error'] == 0) {
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $file_extension;
                $file_path = $upload_dir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    if ($fileModel->saveFile($user_id, $filename, $file['name'], $file['size'], $file['type'])) {
                        echo json_encode(['success' => true, 'message' => 'Archivo subido exitosamente']);
                    } else {
                        unlink($file_path);
                        echo json_encode(['success' => false, 'message' => 'Error al guardar en base de datos']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al subir archivo']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error en el archivo']);
            }
        }
    }
    
    if ($action == 'delete') {
        $file_id = $_POST['file_id'];
        $filename = $fileModel->deleteFile($file_id, $user_id);
        
        if ($filename) {
            $file_path = '../uploads/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            echo json_encode(['success' => true, 'message' => 'Archivo eliminado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar archivo']);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['action']) && $_GET['action'] == 'list') {
        $files = $fileModel->getUserFiles($user_id);
        echo json_encode($files);
    }
    
    if (isset($_GET['action']) && $_GET['action'] == 'download' && isset($_GET['id'])) {
        $file = $fileModel->getFile($_GET['id'], $user_id);
        if ($file) {
            $file_path = '../uploads/' . $file['filename'];
            if (file_exists($file_path)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $file['original_name'] . '"');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit;
            }
        }
        echo "Archivo no encontrado";
    }
}
?>