INSERT INTO usuarios (nombre, email, telefono, password, rol)
VALUES 
('Administrador', 'admin@test.com', '0600000000', '123456', 'admin'),
('Cliente Demo', 'cliente@test.com', '0611111111', '123456', 'cliente'),
('Propietario Demo', 'propietario@test.com', '0622222222', '123456', 'propietario'),
('Capitán Demo', 'capitan@test.com', '0633333333', '123456', 'capitan');

INSERT INTO puertos (nombre, ciudad, direccion)
VALUES 
('Marina Smir', 'Mdiq', 'Marina Smir'),
('Tánger Marina', 'Tánger', 'Puerto de Tánger'),
('Mdiq Port', 'Mdiq', 'Puerto de Mdiq');


INSERT INTO categorias_yates (nombre, descripcion)
VALUES 
('Yate pequeño', 'Yates pequeños para grupos pequeños'),
('Yate mediano', 'Yates medianos para familias o grupos'),
('Yate lujo', 'Yates premium para eventos y experiencias exclusivas');

INSERT INTO yates (
    propietario_id,
    categoria_id,
    puerto_id,
    nombre,
    marca,
    modelo,
    longitud_metros,
    capacidad_personas,
    descripcion,
    tiene_capitan,
    tiene_bano,
    tiene_musica,
    precio_hora,
    precio_dia,
    estado
)
VALUES (
    3,
    2,
    1,
    'Yate Marina Smir 7M',
    'Beneteau',
    'Flyer',
    7.00,
    8,
    'Yate ideal para paseo en Marina Smir.',
    TRUE,
    TRUE,
    TRUE,
    1200.00,
    7000.00,
    'activo'
);

INSERT INTO yates (
    propietario_id,
    categoria_id,
    puerto_id,
    nombre,
    marca,
    modelo,
    longitud_metros,
    capacidad_personas,
    descripcion,
    tiene_capitan,
    tiene_bano,
    tiene_musica,
    precio_hora,
    precio_dia,
    estado
)VALUES (
    3,
    3,
    2,
    'Yate Tánger Marina 15M',
    'Azimut',
    'Grande',
    15.00,
    20,
    'Yate de lujo para eventos en Tánger Marina.',
    TRUE,
    TRUE,
    TRUE,
    3000.00,
    20000.00,
    'activo'
);

INSERT INTO yates (
    propietario_id,
    categoria_id,
    puerto_id,
    nombre,
    marca,
    modelo,
    longitud_metros,
    capacidad_personas,
    descripcion,
    tiene_capitan,
    tiene_bano,
    tiene_musica,
    precio_hora,
    precio_dia,
    estado 
)VALUES (
    3,
    1,
    3,
    'Yate Mdiq Port 5M',
    'Jeanneau',
    'Sun Odyssey',
    5.00,
    6,
    'Yate compacto ideal para paseos en Mdiq Port.',
    TRUE,
    TRUE,
    TRUE,
    800.00,
    5000.00,
    'activo'
);

