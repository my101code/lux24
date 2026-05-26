<?php
/*
 * -----------------------------------------------------------------------------
 * Archivo: adm/index.php
 * Modulo: Panel principal de administracion
 * -----------------------------------------------------------------------------
 * Resumen:
 * - Protege el acceso para usuarios autenticados con rol admin.
 * - Carga los datos basicos del administrador en sesion.
 * - Renderiza la pantalla de bienvenida del panel.
 * - Ofrece accesos rapidos a gestion de usuarios, puertos y logout.
 *
 * Flujo principal:
 * 1) Verifica autenticacion/rol con requireAdmin().
 * 2) Obtiene el nombre del usuario autenticado.
 * 3) Muestra la interfaz de navegacion del area administrativa.
 */
declare(strict_types=1);

require_once __DIR__ . '/../private_locationlux24/auth.php';

$user = requireAdmin('auth_login.php');
$userName = $user['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel Admin | Lux24</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 p-6">
	<main class="mx-auto max-w-4xl rounded-xl bg-white border border-slate-200 shadow p-6">
		<div class="flex items-center justify-between gap-4">
			<div>
				<h1 class="text-2xl font-bold">Panel de administracion</h1>
				<p class="text-sm text-slate-600">Bienvenido, <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>.</p>
			</div>
			<div class="flex items-center gap-2">
				<a href="usuarios.php" class="rounded-lg bg-blue-600 text-white px-4 py-2 text-sm font-semibold">Usuarios</a>
				<a href="puertos.php" class="rounded-lg bg-emerald-600 text-white px-4 py-2 text-sm font-semibold">Puertos</a>
				<a href="../public_html/auth_logout.php" class="rounded-lg bg-slate-800 text-white px-4 py-2 text-sm font-semibold">Logout</a>
			</div>
		</div>
	</main>
</body>
</html>
