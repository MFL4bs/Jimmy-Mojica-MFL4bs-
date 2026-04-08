<?php
require_once 'BaseModel.php';

class Materia extends BaseModel {
    protected $table = 'materias';
    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nombre, codigo, creditos) 
                  VALUES (:nombre, :codigo, :creditos)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':codigo', $data['codigo']);
        $stmt->bindParam(':creditos', $data['creditos']);
        
        return $stmt->execute();
    }
}
?>