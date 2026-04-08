<?php
require_once '../config/database.php';

class MisCursosController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function obtenerCursosMatriculados($usuario_id) {
        $query = "SELECT c.id, c.titulo, c.descripcion, u.nombre as instructor, i.fecha_inscripcion
                  FROM cursos c 
                  INNER JOIN inscripciones i ON c.id = i.curso_id
                  INNER JOIN usuarios u ON c.instructor_id = u.id
                  WHERE i.usuario_id = ?
                  ORDER BY i.fecha_inscripcion DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerArchivosCurso($curso_id) {
        $query = "SELECT * FROM archivos_curso WHERE curso_id = ? ORDER BY fecha_subida DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$curso_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>