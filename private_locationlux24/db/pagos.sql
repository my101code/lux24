CREATE TABLE pagos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    reserva_id BIGINT UNSIGNED NOT NULL,

    cantidad DECIMAL(10,2) NOT NULL,
    metodo ENUM('efectivo', 'tarjeta', 'transferencia', 'online') NOT NULL,

    estado ENUM('pendiente', 'pagado', 'fallido', 'devuelto') NOT NULL DEFAULT 'pendiente',

    referencia VARCHAR(150) NULL,
    comprobante VARCHAR(255) NULL,

    fecha_pago TIMESTAMP NULL,

    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (reserva_id) REFERENCES reservas(id) ON DELETE CASCADE
);