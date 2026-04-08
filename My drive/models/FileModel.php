<?php
require_once '../config/database.php';

class FileModel {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    public function saveFile($user_id, $filename, $original_name, $file_size, $file_type) {
        $query = "INSERT INTO files (user_id, filename, original_name, file_size, file_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id, $filename, $original_name, $file_size, $file_type]);
    }
    
    public function getUserFiles($user_id) {
        $query = "SELECT * FROM files WHERE user_id = ? ORDER BY upload_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function deleteFile($file_id, $user_id) {
        $query = "SELECT filename FROM files WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$file_id, $user_id]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($file) {
            $query = "DELETE FROM files WHERE id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$file_id, $user_id]);
            return $file['filename'];
        }
        return false;
    }
    
    public function getFile($file_id, $user_id) {
        $query = "SELECT * FROM files WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$file_id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>