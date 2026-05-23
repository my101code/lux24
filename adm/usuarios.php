<?php
declare(strict_types=1);

require_once __DIR__ . '/../private_locationlux24/auth.php';
require_once __DIR__ . '/../private_locationlux24/models/usuarios.php';

$admin = requireAdmin('auth_login.php');
$csrfToken = getCsrfToken();

$flash = '';
$flashType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedToken = (string) ($_POST['csrf_token'] ?? '');
    if (!isValidCsrfToken($postedToken)) {
        http_response_code(400);
        exit('CSRF token invalido');
    }

    $action = (string) ($_POST['action'] ?? '');
    $userId = (int) ($_POST['user_id'] ?? 0);

    try {
        if ($userId <= 0) {
            throw new RuntimeException('Usuario invalido.');
        }

        if ($action === 'update_role') {
            $role = (string) ($_POST['role'] ?? '');
            if ($userId === (int) $admin['id'] && $role !== 'admin') {
                throw new RuntimeException('No puedes quitarte el rol admin a ti mismo.');
            }
            updateUserRole($userId, $role);
            $flash = 'Rol actualizado correctamente.';
        } elseif ($action === 'update_status') {
            $status = (string) ($_POST['status'] ?? '');
            if ($userId === (int) $admin['id'] && $status !== 'activo') {
                throw new RuntimeException('No puedes bloquear tu propia cuenta admin.');
            }
            updateUserStatus($userId, $status);
            $flash = 'Estado actualizado correctamente.';
        } else {
            throw new RuntimeException('Accion no permitida.');
        }
    } catch (Throwable $throwable) {
        $flashType = 'error';
        $flash = $throwable->getMessage();
    }
}

$search = trim((string) ($_GET['q'] ?? ''));
$page = (int) ($_GET['page'] ?? 1);
$page = $page < 1 ? 1 : $page;
$perPage = 12;
$offset = ($page - 1) * $perPage;

$totalUsers = countUsers($search);
$totalPages = max(1, (int) ceil($totalUsers / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $perPage;
}

$users = listUsers($search, $perPage, $offset);

$roles = ['admin', 'cliente', 'propietario', 'capitan'];
$states = ['activo', 'bloqueado'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios | Lux24</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 p-4 sm:p-6">
    <main class="mx-auto max-w-7xl rounded-2xl bg-white border border-slate-200 shadow p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Administrar usuarios</h1>
                <p class="text-sm text-slate-500">Sesión: <?= htmlspecialchars((string) $admin['nombre'], ENT_QUOTES, 'UTF-8') ?> (admin)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="index.php" class="rounded-lg bg-slate-200 text-slate-800 px-4 py-2 text-sm font-semibold">Panel</a>
                <a href="../public_html/auth_logout.php" class="rounded-lg bg-slate-900 text-white px-4 py-2 text-sm font-semibold">Logout</a>
            </div>
        </div>

        <?php if ($flash !== ''): ?>
            <div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flashType === 'error' ? 'border-red-200 bg-red-50 text-red-800' : 'border-emerald-200 bg-emerald-50 text-emerald-800' ?>">
                <?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="get" class="mb-4 flex flex-col sm:flex-row gap-2">
            <input
                type="text"
                name="q"
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Buscar por nombre o telefono"
                class="w-full sm:max-w-md rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-4 focus:ring-slate-200"
            >
            <button type="submit" class="rounded-lg bg-blue-600 text-white px-4 py-2 text-sm font-semibold">Buscar</button>
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-3 py-2 font-bold">ID</th>
                        <th class="text-left px-3 py-2 font-bold">Nombre</th>
                        <th class="text-left px-3 py-2 font-bold">Telefono</th>
                        <th class="text-left px-3 py-2 font-bold">Rol</th>
                        <th class="text-left px-3 py-2 font-bold">Estado</th>
                        <th class="text-left px-3 py-2 font-bold">Creado</th>
                        <th class="text-left px-3 py-2 font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="px-3 py-6 text-center text-slate-500">No se encontraron usuarios.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-t border-slate-200">
                                <td class="px-3 py-3"><?= (int) $user['id'] ?></td>
                                <td class="px-3 py-3 font-semibold"><?= htmlspecialchars((string) $user['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-3 py-3"><?= htmlspecialchars((string) $user['telefono'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-3 py-3">
                                    <form method="post" class="flex items-center gap-2">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="update_role">
                                        <input type="hidden" name="user_id" value="<?= (int) $user['id'] ?>">
                                        <select name="role" class="rounded-md border border-slate-300 px-2 py-1">
                                            <?php foreach ($roles as $role): ?>
                                                <option value="<?= $role ?>" <?= (string) $user['rol'] === $role ? 'selected' : '' ?>><?= $role ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="rounded-md bg-slate-800 text-white px-3 py-1">Guardar</button>
                                    </form>
                                </td>
                                <td class="px-3 py-3">
                                    <form method="post" class="flex items-center gap-2">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="user_id" value="<?= (int) $user['id'] ?>">
                                        <select name="status" class="rounded-md border border-slate-300 px-2 py-1">
                                            <?php foreach ($states as $state): ?>
                                                <option value="<?= $state ?>" <?= (string) $user['estado'] === $state ? 'selected' : '' ?>><?= $state ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="rounded-md bg-slate-800 text-white px-3 py-1">Guardar</button>
                                    </form>
                                </td>
                                <td class="px-3 py-3 text-slate-500"><?= htmlspecialchars((string) ($user['created_at'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-3 py-3 text-xs text-slate-500">Rol y estado editables</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <p class="text-sm text-slate-500">Total: <?= $totalUsers ?> usuario(s)</p>
            <div class="flex items-center gap-2">
                <?php $prevPage = $page > 1 ? $page - 1 : 1; ?>
                <?php $nextPage = $page < $totalPages ? $page + 1 : $totalPages; ?>
                <a href="?q=<?= urlencode($search) ?>&page=<?= $prevPage ?>" class="rounded-md border border-slate-300 px-3 py-1.5 text-sm <?= $page <= 1 ? 'pointer-events-none opacity-40' : '' ?>">Anterior</a>
                <span class="text-sm text-slate-600">Pagina <?= $page ?> de <?= $totalPages ?></span>
                <a href="?q=<?= urlencode($search) ?>&page=<?= $nextPage ?>" class="rounded-md border border-slate-300 px-3 py-1.5 text-sm <?= $page >= $totalPages ? 'pointer-events-none opacity-40' : '' ?>">Siguiente</a>
            </div>
        </div>
    </main>
</body>
</html>
