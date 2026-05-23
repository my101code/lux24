<?php
declare(strict_types=1);

require_once __DIR__ . '/../private_locationlux24/models/usuarios.php';

$errors = [];

$formData = [
	'nombre' => '',
	'telefono' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$formData['nombre'] = trim((string) ($_POST['nombre'] ?? ''));
	$formData['telefono'] = trim((string) ($_POST['telefono'] ?? ''));

	$password = (string) ($_POST['password'] ?? '');

	if ($formData['nombre'] === '' || mb_strlen($formData['nombre']) < 3) {
		$errors[] = 'El nombre debe tener al menos 3 caracteres.';
	}

	if ($formData['telefono'] === '') {
		$errors[] = 'El telefono es obligatorio.';
	} elseif (!preg_match('/^[0-9+()\-\s]{7,20}$/', $formData['telefono'])) {
		$errors[] = 'El telefono contiene caracteres no permitidos.';
	}

	if (mb_strlen($password) < 3) {
		$errors[] = 'La contrasena debe tener al menos 3 caracteres.';
	}

	if (empty($errors)) {
		try {
			createUser(
				$formData['nombre'],
				null,
				$formData['telefono'],
				$password
			);

			header('Location: auth_login.php?registered=1');
			exit;
		} catch (RuntimeException $runtimeException) {
			$errors[] = $runtimeException->getMessage();
		} catch (Throwable $throwable) {
			$errors[] = 'No se pudo completar el registro. Intentalo de nuevo.';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro de usuarios | Lux24</title>
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
		<h1 class="text-3xl font-extrabold text-brandDark tracking-tight">Crear cuenta</h1>
		<p class="text-sm text-slate-500 mt-1 mb-6">Registra un nuevo usuario en Lux24.</p>

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
				<label for="nombre" class="mb-1.5 block text-sm font-semibold">Nombre completo</label>
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
				<label for="telefono" class="mb-1.5 block text-sm font-semibold">Telefono</label>
				<input
					id="telefono"
					name="telefono"
					type="text"
					value="<?= htmlspecialchars($formData['telefono'], ENT_QUOTES, 'UTF-8') ?>"
					maxlength="30"
					class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-cyan-100"
					required
				>
				<p class="mt-1 text-xs text-slate-500">Admite numeros, espacios, +, parentesis y guiones.</p>
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
				Registrar usuario
			</button>
		</form>
	</main>
</body>
</html>
