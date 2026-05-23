<?php
declare(strict_types=1);

require_once __DIR__ . '/../private_locationlux24/auth.php';
require_once __DIR__ . '/../private_locationlux24/models/puertos.php';

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

    try {
        if ($action === 'create_port') {
            $nombre = (string) ($_POST['nombre'] ?? '');
            $ciudad = (string) ($_POST['ciudad'] ?? '');
            $direccion = (string) ($_POST['direccion'] ?? '');
            $latitud = parseNullableFloat($_POST['latitud'] ?? null);
            $longitud = parseNullableFloat($_POST['longitud'] ?? null);

            createPort($nombre, $ciudad, $direccion, $latitud, $longitud);
            $flash = 'Puerto creado correctamente.';
        } elseif ($action === 'update_port') {
            $portId = (int) ($_POST['port_id'] ?? 0);
            if ($portId <= 0) {
                throw new RuntimeException('Puerto invalido.');
            }

            $nombre = (string) ($_POST['nombre'] ?? '');
            $ciudad = (string) ($_POST['ciudad'] ?? '');
            $direccion = (string) ($_POST['direccion'] ?? '');
            $latitud = parseNullableFloat($_POST['latitud'] ?? null);
            $longitud = parseNullableFloat($_POST['longitud'] ?? null);

            updatePort($portId, $nombre, $ciudad, $direccion, $latitud, $longitud);
            $flash = 'Puerto actualizado correctamente.';
        } elseif ($action === 'update_status') {
            $portId = (int) ($_POST['port_id'] ?? 0);
            $status = (string) ($_POST['status'] ?? '');
            if ($portId <= 0) {
                throw new RuntimeException('Puerto invalido.');
            }

            updatePortStatus($portId, $status);
            $flash = 'Estado del puerto actualizado.';
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

$totalPorts = countPorts($search);
$totalPages = max(1, (int) ceil($totalPorts / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $perPage;
}

$ports = listPorts($search, $perPage, $offset);

$editPort = null;
if (isset($_GET['edit'])) {
    $editPortId = (int) $_GET['edit'];
    if ($editPortId > 0) {
        $editPort = getPortById($editPortId);
    }
}

function parseNullableFloat(mixed $value): ?float
{
    if ($value === null) {
        return null;
    }

    $raw = trim((string) $value);
    if ($raw === '') {
        return null;
    }

    if (!is_numeric($raw)) {
        throw new RuntimeException('Latitud y longitud deben ser numericos.');
    }

    return (float) $raw;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Puertos | Lux24</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 p-4 sm:p-6">
    <main class="mx-auto max-w-7xl rounded-2xl bg-white border border-slate-200 shadow p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Administrar puertos</h1>
                <p class="text-sm text-slate-500">Sesion: <?= htmlspecialchars((string) $admin['nombre'], ENT_QUOTES, 'UTF-8') ?> (admin)</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="index.php" class="rounded-lg bg-slate-200 text-slate-800 px-4 py-2 text-sm font-semibold">Panel</a>
                <a href="usuarios.php" class="rounded-lg bg-blue-600 text-white px-4 py-2 text-sm font-semibold">Usuarios</a>
                <a href="../public_html/auth_logout.php" class="rounded-lg bg-slate-900 text-white px-4 py-2 text-sm font-semibold">Logout</a>
            </div>
        </div>

        <?php if ($flash !== ''): ?>
            <div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flashType === 'error' ? 'border-red-200 bg-red-50 text-red-800' : 'border-emerald-200 bg-emerald-50 text-emerald-800' ?>">
                <?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <section class="mb-6 rounded-xl border border-slate-200 p-4">
            <h2 class="text-lg font-bold mb-3"><?= $editPort === null ? 'Nuevo puerto' : 'Editar puerto #' . (int) $editPort['id'] ?></h2>
            <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="action" value="<?= $editPort === null ? 'create_port' : 'update_port' ?>">
                <?php if ($editPort !== null): ?>
                    <input type="hidden" name="port_id" value="<?= (int) $editPort['id'] ?>">
                <?php endif; ?>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold" for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" type="text" required maxlength="100" value="<?= htmlspecialchars((string) ($editPort['nombre'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-4 focus:ring-slate-200">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold" for="ciudad">Ciudad</label>
                    <input id="ciudad" name="ciudad" type="text" maxlength="100" value="<?= htmlspecialchars((string) ($editPort['ciudad'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-4 focus:ring-slate-200">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-semibold" for="direccion">Direccion</label>
                    <input id="direccion" name="direccion" type="text" maxlength="255" value="<?= htmlspecialchars((string) ($editPort['direccion'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-4 focus:ring-slate-200">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold" for="latitud">Latitud</label>
                    <input id="latitud" name="latitud" type="text" placeholder="35.1234567" value="<?= htmlspecialchars((string) ($editPort['latitud'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-4 focus:ring-slate-200">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold" for="longitud">Longitud</label>
                    <input id="longitud" name="longitud" type="text" placeholder="-5.1234567" value="<?= htmlspecialchars((string) ($editPort['longitud'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-4 focus:ring-slate-200">
                </div>

                <div class="md:col-span-2 flex items-center gap-2">
                    <button type="submit" class="rounded-lg bg-slate-900 text-white px-4 py-2 text-sm font-semibold">
                        <?= $editPort === null ? 'Crear puerto' : 'Guardar cambios' ?>
                    </button>
                    <?php if ($editPort !== null): ?>
                        <a href="puertos.php" class="rounded-lg bg-slate-200 text-slate-800 px-4 py-2 text-sm font-semibold">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <form method="get" class="mb-4 flex flex-col sm:flex-row gap-2">
            <input type="text" name="q" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar por nombre o ciudad" class="w-full sm:max-w-md rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:ring-4 focus:ring-slate-200">
            <button type="submit" class="rounded-lg bg-blue-600 text-white px-4 py-2 text-sm font-semibold">Buscar</button>
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-3 py-2 font-bold">ID</th>
                        <th class="text-left px-3 py-2 font-bold">Nombre</th>
                        <th class="text-left px-3 py-2 font-bold">Ciudad</th>
                        <th class="text-left px-3 py-2 font-bold">Direccion</th>
                        <th class="text-left px-3 py-2 font-bold">Coordenadas</th>
                        <th class="text-left px-3 py-2 font-bold">Estado</th>
                        <th class="text-left px-3 py-2 font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ports)): ?>
                        <tr>
                            <td colspan="7" class="px-3 py-6 text-center text-slate-500">No se encontraron puertos.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ports as $port): ?>
                            <tr class="border-t border-slate-200">
                                <td class="px-3 py-3"><?= (int) $port['id'] ?></td>
                                <td class="px-3 py-3 font-semibold"><?= htmlspecialchars((string) $port['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-3 py-3"><?= htmlspecialchars((string) ($port['ciudad'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-3 py-3"><?= htmlspecialchars((string) ($port['direccion'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-3 py-3 text-slate-500">
                                    <?= htmlspecialchars((string) ($port['latitud'] ?? '-'), ENT_QUOTES, 'UTF-8') ?>,
                                    <?= htmlspecialchars((string) ($port['longitud'] ?? '-'), ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td class="px-3 py-3">
                                    <form method="post" class="flex items-center gap-2">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="port_id" value="<?= (int) $port['id'] ?>">
                                        <select name="status" class="rounded-md border border-slate-300 px-2 py-1">
                                            <option value="activo" <?= (string) $port['estado'] === 'activo' ? 'selected' : '' ?>>activo</option>
                                            <option value="inactivo" <?= (string) $port['estado'] === 'inactivo' ? 'selected' : '' ?>>inactivo</option>
                                        </select>
                                        <button type="submit" class="rounded-md bg-slate-800 text-white px-3 py-1">Guardar</button>
                                    </form>
                                </td>
                                <td class="px-3 py-3">
                                    <a href="?q=<?= urlencode($search) ?>&page=<?= $page ?>&edit=<?= (int) $port['id'] ?>" class="rounded-md bg-blue-600 text-white px-3 py-1">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <p class="text-sm text-slate-500">Total: <?= $totalPorts ?> puerto(s)</p>
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
