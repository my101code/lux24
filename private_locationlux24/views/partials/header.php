<?php
$isLoggedIn = $isLoggedIn ?? false;
$userName = $userName ?? 'Usuario';
$brandTitle = $brandTitle ?? 'TripYacht';
?>
<header class="h-20 flex items-center justify-between px-8 bg-soft">
    <div class="flex items-center gap-3">
        <div class="w-11 h-11 rounded-full border-2 border-tealDark flex items-center justify-center bg-white">
            <span class="text-xl">⚓</span>
        </div>
        <h1 class="text-2xl font-black"><?= e($brandTitle) ?></h1>
    </div>

    <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
        <a href="#" class="hover:text-teal">Inicio</a>
        <a href="#deals" class="hover:text-teal">Yates</a>
        <a href="#contacto" class="hover:text-teal">Reservas</a>
        <a href="#contacto" class="hover:text-teal">Contacto</a>
    </nav>

    <div class="hidden lg:flex items-center gap-3">
        <?php if ($isLoggedIn): ?>
            <span class="text-sm font-bold">Hola, <?= e((string) $userName) ?></span>
            <a href="auth_logout.php" class="bg-tealDark text-white px-5 py-2 rounded-md font-bold text-sm">
                Logout
            </a>
        <?php else: ?>
            <a href="auth_register.php" class="text-sm font-bold">Register</a>
            <a href="auth_login.php" class="bg-teal text-white px-5 py-2 rounded-md font-bold text-sm">
                Login
            </a>
        <?php endif; ?>
        <button class="text-sm font-bold">EN</button>
    </div>

    <button id="menuBtn" class="lg:hidden text-3xl">☰</button>
</header>

<div id="mobileMenu" class="hidden lg:hidden bg-white px-8 py-5 border-y border-teal/10">
    <div class="flex flex-col gap-4 font-bold">
        <a href="#">Inicio</a>
        <a href="#deals">Yates</a>
        <a href="#contacto">Reservas</a>
        <a href="#contacto">Contacto</a>
    </div>
</div>
