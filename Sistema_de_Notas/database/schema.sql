-- Script para crear la base de datos del Sistema de Notas

CREATE DATABASE IF NOT EXISTS sistema_notas;
USE sistema_notas;

-- Tabla de usuarios (sistema de autenticación)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('administrador', 'docente', 'estudiante') NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de estudiantes
CREATE TABLE estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabla de materias
CREATE TABLE materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    creditos INT NOT NULL DEFAULT 3,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de profesores
CREATE TABLE profesores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    especialidad VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- Tabla de notas
CREATE TABLE notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    materia_id INT NOT NULL,
    nota DECIMAL(3,2) NOT NULL CHECK (nota >= 0 AND nota <= 5),
    fecha DATE NOT NULL,
    observaciones TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
);

-- Datos de ejemplo
-- Usuario administrador por defecto (password: admin123)
INSERT INTO usuarios (username, email, password, rol) VALUES
('admin', 'admin@colegio.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador'),
('docente1', 'docente1@colegio.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente'),
('estudiante1', 'juan.perez@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'estudiante');

INSERT INTO profesores (usuario_id, nombre, apellido, email, especialidad) VALUES
(2, 'Ana', 'Martínez', 'docente1@colegio.edu', 'Matemáticas');

INSERT INTO estudiantes (usuario_id, nombre, apellido, email, fecha_nacimiento) VALUES
(3, 'Juan', 'Pérez', 'juan.perez@email.com', '2005-03-15'),
(NULL, 'María', 'González', 'maria.gonzalez@email.com', '2005-07-22'),
(NULL, 'Carlos', 'Rodríguez', 'carlos.rodriguez@email.com', '2004-11-08');

INSERT INTO materias (nombre, codigo, creditos) VALUES
('Matemáticas', 'MAT001', 4),
('Español', 'ESP001', 3),
('Ciencias Naturales', 'CIE001', 3),
('Historia', 'HIS001', 2),
('Inglés', 'ING001', 3);

INSERT INTO notas (estudiante_id, materia_id, nota, fecha) VALUES
(1, 1, 4.5, '2024-01-15'),
(1, 2, 3.8, '2024-01-16'),
(2, 1, 4.2, '2024-01-15'),
(2, 3, 4.0, '2024-01-17'),
(3, 1, 2.5, '2024-01-15'),
(3, 2, 3.5, '2024-01-16');