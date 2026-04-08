<?php
require_once 'BaseModel.php';

class Usuario extends BaseModel {
    protected $table = 'usuarios';
    
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username AND activo = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (username, email, password, rol) 
                  VALUES (:username, :email, :password, :rol)";
        $stmt = $this->db->prepare($query);
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':rol', $data['rol']);
        
        return $stmt->execute();
    }
    
    public function existsUsername($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }
}
?>