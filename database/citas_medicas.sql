DROP DATABASE IF EXISTS citas_medicas;

CREATE DATABASE citas_medicas
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE citas_medicas;

CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    documento VARCHAR(20) NOT NULL,
    paciente VARCHAR(120) NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    medico VARCHAR(120) NOT NULL,
    especialidad VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo TEXT NOT NULL,
    estado ENUM('Programada','Atendida','Cancelada') NOT NULL DEFAULT 'Programada',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO citas
(documento, paciente, telefono, correo, medico, especialidad, fecha, hora, motivo, estado)
VALUES
(
    '1090123456',
    'Paciente de ejemplo',
    '3001234567',
    'paciente@ejemplo.com',
    'Dra. Ana Pérez',
    'Medicina General',
    CURDATE(),
    '10:00:00',
    'Consulta médica de ejemplo para verificar el funcionamiento del sistema.',
    'Programada'
);
