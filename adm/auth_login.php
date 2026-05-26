<?php
/*
 * -----------------------------------------------------------------------------
 * Archivo: adm/auth_login.php
 * Modulo: Acceso al panel de administracion
 * -----------------------------------------------------------------------------
 * Resumen:
 * - Gestiona el login de usuarios con rol admin.
 * - Valida nombre y contrasena enviados por POST.
 * - Autentica contra el modelo de usuarios y crea sesion segura.
 * - Redirige al panel principal cuando el acceso es correcto.
 *
 * Flujo principal:
 * 1) Si ya existe sesion admin activa, redirige al panel.
 * 2) Si llega POST, valida datos y credenciales.
 * 3) Si todo es valido, guarda datos de sesion y redirige.
 * 4) Si hay errores, los muestra en la vista.
 */
declare(strict_types=1); // Iniciar sesion para gestionar el estado de autenticacion

session_start(); // Asegura que la sesion este activa para manejar autenticacion

require_once __DIR__ . '/../private_locationlux24/models/usuarios.php';

if (isset($_SESSION['user_id']) && (string) ($_SESSION['user_role'] ?? '') === 'admin') {
	header('Location: index.php');
	exit;
}

$errors = [];

$formData = [
	'nombre' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$formData['nombre'] = trim((string) ($_POST['nombre'] ?? ''));
	$password = (string) ($_POST['password'] ?? '');

	if ($formData['nombre'] === '' || mb_strlen($formData['nombre']) < 3) {
		$errors[] = 'El nombre es obligatorio y debe tener al menos 3 caracteres.';
	}

	if (mb_strlen($password) < 3) {
		$errors[] = 'La contrasena debe tener al menos 3 caracteres.';
	}

	if (empty($errors)) {
		try {
			$user = authenticateUserByName($formData['nombre'], $password);
			if ($user === null) {
				$errors[] = 'Credenciales incorrectas.';
			} elseif ((string) ($user['rol'] ?? '') !== 'admin') {
				$errors[] = 'No tienes permisos de administrador.';
			} else {
				session_regenerate_id(true);
				$_SESSION['user_id'] = (int) $user['id'];
				$_SESSION['user_name'] = (string) $user['nombre'];
				$_SESSION['user_role'] = (string) $user['rol'];

				header('Location: index.php');
				exit;
			}
		} catch (RuntimeException $runtimeException) {
			$errors[] = $runtimeException->getMessage();
		} catch (Throwable $throwable) {
			$errors[] = 'No se pudo iniciar sesion. Intentalo de nuevo.';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Admin | Lux24</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 p-4 sm:p-6 grid place-items-center">
	<main class="w-full max-w-md rounded-2xl bg-white border border-slate-200 shadow p-6 sm:p-8">
		<h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Acceso Admin</h1>
		<p class="text-sm text-slate-500 mt-1 mb-6">Inicia sesion para entrar al panel de administracion.</p>

		<?php if (!empty($errors)): ?>
			<div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
				<ul class="list-disc pl-5 space-y-1">
					<?php foreach ($errors as $error): ?>
						<li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<form action="" method="post" novalidate class="space-y-4">
			<div>
				<label for="nombre" class="mb-1.5 block text-sm font-semibold">Nombre</label>
				<input
					id="nombre"
					name="nombre"
					type="text"
					value="<?= htmlspecialchars($formData['nombre'], ENT_QUOTES, 'UTF-8') ?>"
					maxlength="100"
					class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-200"
					required
				>
			</div>

			<div>
				<label for="password" class="mb-1.5 block text-sm font-semibold">Contrasena</label>
				<input
					id="password"
					name="password"
					type="password"
					minlength="3"
					class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-4 focus:ring-slate-200"
					required
				>
			</div>

			<button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
				Entrar al panel
			</button>
		</form>

		<p class="mt-5 text-center text-sm text-slate-500">
			<a href="../public_html/index.php" class="font-semibold text-slate-700 hover:text-slate-900">Volver al sitio</a>
		</p>
	</main>
</body>
</html>
