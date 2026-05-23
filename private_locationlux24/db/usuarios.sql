CREATE TABLE usuarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NULL,
    telefono VARCHAR(30) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,

    rol ENUM('admin', 'cliente', 'propietario', 'capitan') NOT NULL DEFAULT 'cliente',

    foto VARCHAR(255) NULL,
    estado ENUM('activo', 'bloqueado') NOT NULL DEFAULT 'activo',

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);