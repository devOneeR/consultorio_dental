CREATE DATABASE IF NOT EXISTS consultorio_dental;

USE consultorio_dental;
CREATE TABLE IF NOT EXISTS pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    edad INT NOT NULL,
    motivo_visita VARCHAR(200) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pacientes (nombre, apellido, cedula, edad, motivo_visita) VALUES
('Juan', 'Pérez', '402-0838333-2', 30, 'Dolor de muelas'),
('María', 'Gómez', '402-0838343-1', 25, 'Revisión general'),
('Carlos', 'López', '402-0838354-0', 40, 'Ortodoncia'),
('Ana', 'Martínez', '402-0838365-9', 35, 'Limpieza dental');