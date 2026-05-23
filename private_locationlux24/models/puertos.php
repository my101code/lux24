<?php
declare(strict_types=1);

require_once __DIR__ . '/../db.php';

function listPorts(string $search = '', int $limit = 20, int $offset = 0): array
{
    $pdo = getDbConnection();

    $sql = 'SELECT id, nombre, ciudad, direccion, latitud, longitud, estado, created_at FROM puertos';
    $params = [];

    if ($search !== '') {
        $sql .= ' WHERE nombre LIKE :search_nombre OR ciudad LIKE :search_ciudad';
        $params['search_nombre'] = '%' . $search . '%';
        $params['search_ciudad'] = '%' . $search . '%';
    }

    $sql .= ' ORDER BY id DESC LIMIT :limit OFFSET :offset';
    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
    }

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll();

    return is_array($rows) ? $rows : [];
}

function countPorts(string $search = ''): int
{
    $pdo = getDbConnection();

    $sql = 'SELECT COUNT(*) AS total FROM puertos';
    $params = [];

    if ($search !== '') {
        $sql .= ' WHERE nombre LIKE :search_nombre OR ciudad LIKE :search_ciudad';
        $params['search_nombre'] = '%' . $search . '%';
        $params['search_ciudad'] = '%' . $search . '%';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $total = $stmt->fetchColumn();

    return $total === false ? 0 : (int) $total;
}

function getPortById(int $portId): ?array
{
    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        'SELECT id, nombre, ciudad, direccion, latitud, longitud, estado, created_at FROM puertos WHERE id = :id LIMIT 1'
    );
    $stmt->execute(['id' => $portId]);

    $port = $stmt->fetch();

    return $port === false ? null : $port;
}

function createPort(string $nombre, ?string $ciudad, ?string $direccion, ?float $latitud, ?float $longitud): int
{
    validatePortData($nombre, $latitud, $longitud);

    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        'INSERT INTO puertos (nombre, ciudad, direccion, latitud, longitud, estado) VALUES (:nombre, :ciudad, :direccion, :latitud, :longitud, :estado)'
    );

    $stmt->execute([
        'nombre' => trim($nombre),
        'ciudad' => normalizeNullableText($ciudad),
        'direccion' => normalizeNullableText($direccion),
        'latitud' => $latitud,
        'longitud' => $longitud,
        'estado' => 'activo',
    ]);

    return (int) $pdo->lastInsertId();
}

function updatePort(int $portId, string $nombre, ?string $ciudad, ?string $direccion, ?float $latitud, ?float $longitud): void
{
    validatePortData($nombre, $latitud, $longitud);

    $pdo = getDbConnection();

    $stmt = $pdo->prepare(
        'UPDATE puertos SET nombre = :nombre, ciudad = :ciudad, direccion = :direccion, latitud = :latitud, longitud = :longitud WHERE id = :id'
    );

    $stmt->execute([
        'id' => $portId,
        'nombre' => trim($nombre),
        'ciudad' => normalizeNullableText($ciudad),
        'direccion' => normalizeNullableText($direccion),
        'latitud' => $latitud,
        'longitud' => $longitud,
    ]);
}

function updatePortStatus(int $portId, string $status): void
{
    $allowedStatus = ['activo', 'inactivo'];
    if (!in_array($status, $allowedStatus, true)) {
        throw new RuntimeException('Estado no permitido.');
    }

    $pdo = getDbConnection();

    $stmt = $pdo->prepare('UPDATE puertos SET estado = :estado WHERE id = :id');
    $stmt->execute([
        'estado' => $status,
        'id' => $portId,
    ]);
}

function normalizeNullableText(?string $value): ?string
{
    if ($value === null) {
        return null;
    }

    $normalized = trim($value);

    return $normalized === '' ? null : $normalized;
}

function validatePortData(string $nombre, ?float $latitud, ?float $longitud): void
{
    $nombre = trim($nombre);

    if ($nombre === '' || mb_strlen($nombre) < 2) {
        throw new RuntimeException('El nombre del puerto es obligatorio y debe tener al menos 2 caracteres.');
    }

    if ($latitud !== null && ($latitud < -90 || $latitud > 90)) {
        throw new RuntimeException('La latitud debe estar entre -90 y 90.');
    }

    if ($longitud !== null && ($longitud < -180 || $longitud > 180)) {
        throw new RuntimeException('La longitud debe estar entre -180 y 180.');
    }
}
