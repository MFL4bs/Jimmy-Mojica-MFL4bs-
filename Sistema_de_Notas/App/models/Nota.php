<?php
require_once 'BaseModel.php';

class Nota extends BaseModel {
    protected $table = 'notas';
    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (estudiante_id, materia_id, nota, fecha) 
                  VALUES (:estudiante_id, :materia_id, :nota, :fecha)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':estudiante_id', $data['estudiante_id']);
        $stmt->bindParam(':materia_id', $data['materia_id']);
        $stmt->bindParam(':nota', $data['nota']);
        $stmt->bindParam(':fecha', $data['fecha']);
        
        return $stmt->execute();
    }
    
    public function getAllWithDetails() {
        $query = "SELECT n.*, e.nombre as estudiante_nombre, e.apellido as estudiante_apellido, 
                         m.nombre as materia_nombre 
                  FROM " . $this->table . " n
                  JOIN estudiantes e ON n.estudiante_id = e.id
                  JOIN materias m ON n.materia_id = m.id
                  ORDER BY n.fecha DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>