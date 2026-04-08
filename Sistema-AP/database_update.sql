-- Actualización de Base de Datos - Sistema de Aprendizaje
-- Ejecutar este script después de la instalación inicial

USE sistema_aprendizaje;

-- Agregar usuario estudiante de ejemplo
INSERT INTO usuarios (nombre, email, password, tipo) VALUES 
('Estudiante Demo', 'estudiante@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'estudiante');

-- Crear tabla para archivos de cursos
CREATE TABLE archivos_curso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(500) NOT NULL,
    tipo_archivo VARCHAR(50),
    tamaño_archivo INT,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- Verificar usuarios creados
SELECT id, nombre, email, tipo FROM usuarios;