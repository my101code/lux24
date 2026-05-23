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
