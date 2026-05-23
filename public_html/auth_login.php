<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../private_locationlux24/models/usuarios.php';

if (isset($_SESSION['user_id'])) {
	header('Location: index.php');
	exit;
}

$errors = [];
$successMessage = '';

if (isset($_GET['registered']) && $_GET['registered'] === '1') {
	$successMessage = 'Usuario registrado correctamente. Ahora puedes iniciar sesion.';
}

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
				$errors[] = 'Nombre o contrasena incorrectos.';
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
	<title>Iniciar sesion | Lux24</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					colors: {
						brand: "#0c7a86",
						brandDark: "#07535c"
					},
					boxShadow: {
						card: "0 18px 40px rgba(7, 83, 92, 0.15)"
					}
				}
			}
		};
	</script>
</head>
<body class="min-h-screen bg-gradient-to-br from-cyan-50 via-slate-100 to-slate-200 text-slate-800 p-4 sm:p-6 grid place-items-center">
	<main class="w-full max-w-lg rounded-2xl bg-white shadow-card p-6 sm:p-8 border border-slate-200">
		<h1 class="text-3xl font-extrabold text-brandDark tracking-tight">Iniciar sesion</h1>
		<p class="text-sm text-slate-500 mt-1 mb-6">Accede con tu nombre y contrasena.</p>

		<?php if (!empty($errors)): ?>
			<div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
				<ul class="list-disc pl-5 space-y-1">
					<?php foreach ($errors as $error): ?>
						<li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ($successMessage !== ''): ?>
			<div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
				<?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?>
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
					class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-cyan-100"
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
					class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-cyan-100"
					required
				>
			</div>

			<button
				type="submit"
				class="w-full rounded-xl bg-gradient-to-r from-brand to-brandDark px-4 py-3 text-sm font-bold text-white transition hover:brightness-105 focus:outline-none focus:ring-4 focus:ring-cyan-200"
			>
				Entrar
			</button>
		</form>

		<p class="mt-5 text-center text-sm text-slate-500">
			No tienes cuenta?
			<a href="auth_register.php" class="font-semibold text-brand hover:text-brandDark">Crear cuenta</a>
		</p>
	</main>
</body>
</html>
