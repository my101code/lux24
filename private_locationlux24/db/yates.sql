CREATE TABLE yates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    propietario_id BIGINT UNSIGNED NOT NULL,
    categoria_id BIGINT UNSIGNED NULL,
    puerto_id BIGINT UNSIGNED NULL,

    nombre VARCHAR(150) NOT NULL,
    marca VARCHAR(100) NULL,
    modelo VARCHAR(100) NULL,

    longitud_metros DECIMAL(5,2) NULL,
    capacidad_personas INT NOT NULL DEFAULT 1,

    descripcion TEXT NULL,

    tiene_capitan BOOLEAN NOT NULL DEFAULT TRUE,
    tiene_bano BOOLEAN NOT NULL DEFAULT FALSE,
    tiene_musica BOOLEAN NOT NULL DEFAULT FALSE,
    tiene_wifi BOOLEAN NOT NULL DEFAULT FALSE,
    tiene_comida BOOLEAN NOT NULL DEFAULT FALSE,

    precio_hora DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    precio_dia DECIMAL(10,2) NULL,

    estado ENUM('pendiente', 'activo', 'inactivo', 'bloqueado') NOT NULL DEFAULT 'pendiente',

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (propietario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias_yates(id) ON DELETE SET NULL,
    FOREIGN KEY (puerto_id) REFERENCES puertos(id) ON DELETE SET NULL
);