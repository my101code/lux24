<?php
declare(strict_types=1);

require_once __DIR__ . '/../db.php';

function findUserByEmailOrPhone(PDO $pdo, ?string $email, string $telefono): ?array
{
	if ($email === null) {
		$stmt = $pdo->prepare(
			'SELECT id, email, telefono FROM usuarios WHERE telefono = :telefono LIMIT 1'
		);
		$stmt->execute([
			'telefono' => $telefono,
		]);
	} else {
		$stmt = $pdo->prepare(
			'SELECT id, email, telefono FROM usuarios WHERE telefono = :telefono OR email = :email LIMIT 1'
		);
		$stmt->execute([
			'telefono' => $telefono,
			'email' => $email,
		]);
	}

	$user = $stmt->fetch();

	return $user === false ? null : $user;
}

function createUser(string $nombre, ?string $email, string $telefono, string $password): int
{
	$pdo = getDbConnection();

	$existing = findUserByEmailOrPhone($pdo, $email, $telefono);
	if ($existing !== null) {
		throw new RuntimeException('El email o telefono ya esta registrado.');
	}

	$passwordHash = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $pdo->prepare(
		'INSERT INTO usuarios (nombre, email, telefono, password, rol, estado) VALUES (:nombre, :email, :telefono, :password, :rol, :estado)'
	);

	$stmt->execute([
		'nombre' => $nombre,
		'email' => $email,
		'telefono' => $telefono,
		'password' => $passwordHash,
		'rol' => 'cliente',
		'estado' => 'activo',
	]);

	return (int) $pdo->lastInsertId();
}

function authenticateUserByPhone(string $telefono, string $password): ?array
{
	$pdo = getDbConnection();

	$stmt = $pdo->prepare(
		'SELECT id, nombre, email, telefono, password, rol, estado FROM usuarios WHERE telefono = :telefono LIMIT 1'
	);
	$stmt->execute([
		'telefono' => $telefono,
	]);

	$user = $stmt->fetch();
	if ($user === false) {
		return null;
	}

	if ($user['estado'] !== 'activo') {
		throw new RuntimeException('Tu cuenta esta bloqueada. Contacta con soporte.');
	}

	if (!password_verify($password, $user['password'])) {
		return null;
	}

	unset($user['password']);

	return $user;
}

function authenticateUserByName(string $nombre, string $password): ?array
{
	$pdo = getDbConnection();

	$stmt = $pdo->prepare(
		'SELECT id, nombre, email, telefono, password, rol, estado FROM usuarios WHERE nombre = :nombre LIMIT 1'
	);
	$stmt->execute([
		'nombre' => $nombre,
	]);

	$user = $stmt->fetch();
	if ($user === false) {
		return null;
	}

	if ($user['estado'] !== 'activo') {
		throw new RuntimeException('Tu cuenta esta bloqueada. Contacta con soporte.');
	}

	if (!password_verify($password, $user['password'])) {
		return null;
	}

	unset($user['password']);

	return $user;
}

function listUsers(string $search = '', int $limit = 20, int $offset = 0): array
{
	$pdo = getDbConnection();

	$sql = 'SELECT id, nombre, email, telefono, rol, estado, created_at FROM usuarios';
	$params = [];

	if ($search !== '') {
		$sql .= ' WHERE nombre LIKE :search_nombre OR telefono LIKE :search_telefono';
		$params['search_nombre'] = '%' . $search . '%';
		$params['search_telefono'] = '%' . $search . '%';
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

function countUsers(string $search = ''): int
{
	$pdo = getDbConnection();

	$sql = 'SELECT COUNT(*) AS total FROM usuarios';
	$params = [];

	if ($search !== '') {
		$sql .= ' WHERE nombre LIKE :search_nombre OR telefono LIKE :search_telefono';
		$params['search_nombre'] = '%' . $search . '%';
		$params['search_telefono'] = '%' . $search . '%';
	}

	$stmt = $pdo->prepare($sql);
	$stmt->execute($params);
	$total = $stmt->fetchColumn();

	return $total === false ? 0 : (int) $total;
}

function updateUserRole(int $userId, string $role): void
{
	$allowedRoles = ['admin', 'cliente', 'propietario', 'capitan'];
	if (!in_array($role, $allowedRoles, true)) {
		throw new RuntimeException('Rol no permitido.');
	}

	$pdo = getDbConnection();
	$stmt = $pdo->prepare('UPDATE usuarios SET rol = :rol WHERE id = :id');
	$stmt->execute([
		'rol' => $role,
		'id' => $userId,
	]);
}

function updateUserStatus(int $userId, string $status): void
{
	$allowedStatus = ['activo', 'bloqueado'];
	if (!in_array($status, $allowedStatus, true)) {
		throw new RuntimeException('Estado no permitido.');
	}

	$pdo = getDbConnection();
	$stmt = $pdo->prepare('UPDATE usuarios SET estado = :estado WHERE id = :id');
	$stmt->execute([
		'estado' => $status,
		'id' => $userId,
	]);
}
