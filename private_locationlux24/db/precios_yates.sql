CREATE TABLE precios_yates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    yate_id BIGINT UNSIGNED NOT NULL,

    titulo VARCHAR(100) NOT NULL,
    tipo ENUM('hora', 'medio_dia', 'dia', 'oferta') NOT NULL DEFAULT 'hora',

    duracion_horas INT NULL,
    precio DECIMAL(10,2) NOT NULL,

    fecha_inicio DATE NULL,
    fecha_fin DATE NULL,

    estado ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (yate_id) REFERENCES yates(id) ON DELETE CASCADE
);