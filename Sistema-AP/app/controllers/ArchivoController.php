<?php
require_once '../config/database.php';

class ArchivoController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function subirArchivo($curso_id, $archivo) {
        $directorio = '../public/uploads/';
        $nombre_archivo = time() . '_' . $archivo['name'];
        $ruta_completa = $directorio . $nombre_archivo;
        
        if(move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
            $query = "INSERT INTO archivos_curso (curso_id, nombre_archivo, ruta_archivo, tipo_archivo, tamaño_archivo) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            
            return $stmt->execute([
                $curso_id,
                $archivo['name'],
                'uploads/' . $nombre_archivo,
                $archivo['type'],
                $archivo['size']
            ]);
        }
        return false;
    }

    public function obtenerArchivosCurso($curso_id) {
        $query = "SELECT * FROM archivos_curso WHERE curso_id = ? ORDER BY fecha_subida DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$curso_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>