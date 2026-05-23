<?php
declare(strict_types=1);

function ensureSessionStarted(): void
{
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
}

function currentUser(): ?array
{
	ensureSessionStarted();

	if (!isset($_SESSION['user_id'])) {
		return null;
	}

	return [
		'id' => (int) $_SESSION['user_id'],
		'nombre' => (string) ($_SESSION['user_name'] ?? 'Usuario'),
		'rol' => (string) ($_SESSION['user_role'] ?? ''),
	];
}

function requireAdmin(string $loginPath = '../adm/auth_login.php'): array
{
	$user = currentUser();

	if ($user === null) {
		header('Location: ' . $loginPath);
		exit;
	}

	if ($user['rol'] !== 'admin') {
		http_response_code(403);
		echo 'Acceso denegado';
		exit;
	}

	return $user;
}

function getCsrfToken(): string
{
	ensureSessionStarted();

	if (!isset($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}

	return (string) $_SESSION['csrf_token'];
}

function isValidCsrfToken(?string $token): bool
{
	ensureSessionStarted();

	if ($token === null || !isset($_SESSION['csrf_token'])) {
		return false;
	}

	return hash_equals((string) $_SESSION['csrf_token'], $token);
}
