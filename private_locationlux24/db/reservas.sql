CREATE TABLE reservas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    codigo_reserva VARCHAR(50) UNIQUE NOT NULL,

    cliente_id BIGINT UNSIGNED NOT NULL,
    yate_id BIGINT UNSIGNED NOT NULL,
    capitan_id BIGINT UNSIGNED NULL,
    puerto_id BIGINT UNSIGNED NULL,

    fecha_reserva DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NULL,

    duracion_horas INT NOT NULL,
    cantidad_personas INT NOT NULL,

    precio_hora DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    comision_plataforma DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia', 'online') NULL,

    estado ENUM(
        'pendiente',
        'aceptada',
        'rechazada',
        'pagada',
        'confirmada',
        'en_camino',
        'en_curso',
        'completada',
        'cancelada'
    ) NOT NULL DEFAULT 'pendiente',

    notas_cliente TEXT NULL,
    notas_admin TEXT NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (cliente_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (yate_id) REFERENCES yates(id) ON DELETE CASCADE,
    FOREIGN KEY (capitan_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (puerto_id) REFERENCES puertos(id) ON DELETE SET NULL
);