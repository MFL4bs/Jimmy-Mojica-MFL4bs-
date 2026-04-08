<?php
require_once '../config/database.php';

class User {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    public function register($username, $email, $password, $storage_gb = 10) {
        $storage_bytes = $storage_gb * 1024 * 1024 * 1024;
        $query = "INSERT INTO users (username, email, password, storage_limit) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $email, $hashed_password, $storage_bytes]);
    }
    
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function userExists($username, $email) {
        $query = "SELECT id FROM users WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $email]);
        return $stmt->fetch() ? true : false;
    }
    
    public function getUserStorageInfo($user_id) {
        $query = "SELECT SUM(f.file_size) as total_used, u.storage_limit FROM files f RIGHT JOIN users u ON f.user_id = u.id WHERE u.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $total_used = $result['total_used'] ?? 0;
        $total_limit = $result['storage_limit'] ?? (10 * 1024 * 1024 * 1024);
        $percentage = ($total_used / $total_limit) * 100;
        
        return [
            'used' => $total_used,
            'limit' => $total_limit,
            'percentage' => min($percentage, 100)
        ];
    }
}
?>