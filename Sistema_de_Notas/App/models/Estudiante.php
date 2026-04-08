<?php
require_once 'BaseModel.php';

class Estudiante extends BaseModel {
    protected $table = 'estudiantes';
    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nombre, apellido, email, fecha_nacimiento) 
                  VALUES (:nombre, :apellido, :email, :fecha_nacimiento)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, apellido = :apellido, email = :email, fecha_nacimiento = :fecha_nacimiento 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellido', $data['apellido']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        
        return $stmt->execute();
    }
}
?>