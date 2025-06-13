CREATE DATABASE IF NOT EXISTS consultorio_dental;

USE consultorio_dental;

CREATE TABLE IF NOT EXISTS pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    edad INT NOT NULL,
    motivo_visita VARCHAR(100) NOT NULL,
    fecha_hora DATETIME NOT NULL
);

INSERT INTO pacientes (nombre, apellido, cedula, edad, motivo_visita, fecha_hora) VALUES
('Juan', 'Pérez', 'V-12345678', 35, 'Limpieza dental', '2023-06-10 09:30:00'),
('María', 'González', 'V-23456789', 42, 'Dolor de muela', '2023-06-10 11:00:00'),
('Carlos', 'Rodríguez', 'V-34567890', 28, 'Revisión de ortodoncia', '2023-06-11 10:15:00'),
('Ana', 'Martínez', 'V-45678901', 50, 'Extracción', '2023-06-11 15:30:00'),
('Pedro', 'Sánchez', 'V-56789012', 19, 'Caries', '2023-06-12 14:00:00');