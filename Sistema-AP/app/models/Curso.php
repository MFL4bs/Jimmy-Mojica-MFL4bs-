<?php
class Curso {
    private $conn;
    private $table_name = "cursos";

    public $id;
    public $titulo;
    public $descripcion;
    public $instructor_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT c.id, c.titulo, c.descripcion, u.nombre as instructor 
                  FROM " . $this->table_name . " c 
                  LEFT JOIN usuarios u ON c.instructor_id = u.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " SET titulo=:titulo, descripcion=:descripcion, instructor_id=:instructor_id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":instructor_id", $this->instructor_id);

        return $stmt->execute();
    }
}
?>