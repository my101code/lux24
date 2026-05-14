<?php
$empresa = "Location de Yates";
$lugar = "Marina Smir";
$whatsapp = "+212654926279";

$destinos = [
    "Marina Smir",
    "Cabo Negro",
    "Mdiq",
    "Restinga",
    "Kabila"
];

$yates = [
    [
        "titulo" => "Yate Privado Marina Smir",
        "descuento" => "30 % off",
        "imagen" => "https://images.unsplash.com/photo-1567899378494-47b22a2ae96a?auto=format&fit=crop&w=900&q=80",
        "personas" => "8 personas",
        "duracion" => "Salida por horas",
        "fecha" => "Oferta hasta finales de mayo",
        "precio_antiguo" => "1,600",
        "precio" => "1,200",
        "rating" => "4.8"
    ],
    [
        "titulo" => "Yate Mediano Premium",
        "descuento" => "20 % off",
        "imagen" => "https://images.unsplash.com/photo-1605281317010-fe5ffe798166?auto=format&fit=crop&w=900&q=80",
        "personas" => "10 personas",
        "duracion" => "Medio día disponible",
        "fecha" => "Reserva anticipada",
        "precio_antiguo" => "2,500",
        "precio" => "2,000",
        "rating" => "4.9"
    ],
    [
        "titulo" => "Paseo Familiar en Yate",
        "descuento" => "40 % off",
        "imagen" => "https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=900&q=80",
        "personas" => "6 personas",
        "duracion" => "Ideal para familias",
        "fecha" => "Disponible esta semana",
        "precio_antiguo" => "1,900",
        "precio" => "1,450",
        "rating" => "4.7"
    ],
    [
        "titulo" => "Yate Pequeño Relax",
        "descuento" => "25 % off",
        "imagen" => "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80",
        "personas" => "6 personas",
        "duracion" => "Perfecto para fotos",
        "fecha" => "Salida rápida",
        "precio_antiguo" => "1,500",
        "precio" => "1,200",
        "rating" => "4.6"
    ],
    [
        "titulo" => "Experiencia Sunset",
        "descuento" => "24 % off",
        "imagen" => "https://images.unsplash.com/photo-1528154291023-a6525fabe5b4?auto=format&fit=crop&w=900&q=80",
        "personas" => "8 personas",
        "duracion" => "Atardecer en el mar",
        "fecha" => "Reserva limitada",
        "precio_antiguo" => "2,200",
        "precio" => "1,750",
        "rating" => "4.9"
    ],
    [
        "titulo" => "Tour Azul Marina",
        "descuento" => "15 % off",
        "imagen" => "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80",
        "personas" => "12 personas",
        "duracion" => "Grupo privado",
        "fecha" => "Disponible por horas",
        "precio_antiguo" => "3,000",
        "precio" => "2,600",
        "rating" => "4.8"
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $empresa ?> | <?= $lugar ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        page: "#B7CBC6",
                        teal: "#08B8C7",
                        tealDark: "#073C43",
                        soft: "#F7F9F4",
                        gold: "#D6A01D",
                        cream: "#FFF8E7"
                    },
                    fontFamily: {
                        title: ["Playfair Display", "serif"],
                        body: ["Inter", "sans-serif"]
                    },
                    boxShadow: {
                        soft: "0 20px 60px rgba(7,60,67,0.15)"
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
</head>

<body class="bg-page font-body text-tealDark">

<div class="max-w-[1420px] mx-auto p-4 md:p-8">

    <section class="gap-8 items-start">

        <div class="bg-soft rounded-[2rem] overflow-hidden shadow-soft">

            <header class="h-20 flex items-center justify-between px-8 bg-soft">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full border-2 border-tealDark flex items-center justify-center bg-white">
                        <span class="text-xl">⚓</span>
                    </div>
                    <h1 class="text-2xl font-black">TripYacht</h1>
                </div>

                <nav class="hidden lg:flex items-center gap-8 text-sm font-bold">
                    <a href="#" class="hover:text-teal">Inicio</a>
                    <a href="#deals" class="hover:text-teal">Yates</a>
                    <a href="#contacto" class="hover:text-teal">Reservas</a>
                    <a href="#contacto" class="hover:text-teal">Contacto</a>
                </nav>

                <div class="hidden lg:flex items-center gap-3">
                    <a href="#" class="text-sm font-bold">Register</a>
                    <a href="https://wa.me/<?= $whatsapp ?>" class="bg-teal text-white px-5 py-2 rounded-md font-bold text-sm">
                        Login
                    </a>
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

            <section class="relative min-h-[520px] px-8 pb-10">
                <div class="absolute inset-x-8 top-0 h-[460px] rounded-b-[2rem] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1540946485063-a40da27545f8?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover" alt="Yate en Marina Smir">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/10 via-transparent to-teal/10"></div>
                </div>

                <div class="relative pt-20 flex items-end min-h-[520px]">
                    <div class="bg-white rounded-xl shadow-soft w-full max-w-[430px] p-6 -mb-2">
                        <h2 class="font-title text-5xl leading-[0.95] mb-6">
                            What Is Your <br>
                            <span class="text-teal italic">Destination?</span>
                        </h2>

                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <p class="text-[10px] uppercase font-black text-gray-400">From</p>
                                <select class="w-full border-b border-gray-200 py-2 font-bold outline-none bg-white">
                                    <option>Marina Smir</option>
                                    <option>Mdiq</option>
                                    <option>Cabo Negro</option>
                                </select>
                            </div>

                            <div>
                                <p class="text-[10px] uppercase font-black text-gray-400">To</p>
                                <select class="w-full border-b border-gray-200 py-2 font-bold outline-none bg-white">
                                    <option>Relax Tour</option>
                                    <option>Sunset Tour</option>
                                    <option>Private Trip</option>
                                </select>
                            </div>

                            <div>
                                <p class="text-[10px] uppercase font-black text-gray-400">Departure</p>
                                <input type="date" class="w-full border-b border-gray-200 py-2 font-bold outline-none">
                            </div>

                            <div>
                                <p class="text-[10px] uppercase font-black text-gray-400">Return</p>
                                <input type="date" class="w-full border-b border-gray-200 py-2 font-bold outline-none">
                            </div>

                            <div>
                                <p class="text-[10px] uppercase font-black text-gray-400">Guests</p>
                                <div class="flex items-center gap-3 py-2">
                                    <button class="guestMinus w-7 h-7 rounded-full border border-gray-300 font-black">−</button>
                                    <span id="guests" class="font-black">6</span>
                                    <button class="guestPlus w-7 h-7 rounded-full border border-gray-300 font-black">+</button>
                                </div>
                            </div>

                            <div>
                                <p class="text-[10px] uppercase font-black text-gray-400">Yacht</p>
                                <div class="flex items-center gap-3 py-2">
                                    <button class="roomMinus w-7 h-7 rounded-full border border-gray-300 font-black">−</button>
                                    <span id="rooms" class="font-black">1</span>
                                    <button class="roomPlus w-7 h-7 rounded-full border border-gray-300 font-black">+</button>
                                </div>
                            </div>
                        </div>

                        <a href="https://wa.me/<?= $whatsapp ?>" class="block text-center bg-teal hover:bg-tealDark text-white font-black py-4 rounded-md mt-6 transition">
                            Get your deal now
                        </a>
                    </div>
                </div>
            </section>

            <section id="deals" class="px-8 pb-12">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-6">
                    <h2 class="font-title text-4xl italic">Best yacht deals</h2>

                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2">⌕</span>
                            <input id="searchInput" type="text" placeholder="SEARCH YOUR NEXT CITY" class="pl-10 pr-4 py-3 rounded-full border border-gray-200 text-xs font-black outline-none w-64">
                        </div>
                        <button class="bg-tealDark text-white px-6 py-3 rounded-full text-xs font-black">
                            Search
                        </button>
                    </div>
                </div>

                <div class="flex gap-3 overflow-x-auto pb-5">
                    <button class="filterBtn activeFilter shrink-0 px-7 py-3 rounded-full bg-teal text-white text-xs font-black" data-filter="all">All</button>
                    <?php foreach ($destinos as $destino): ?>
                        <button class="filterBtn shrink-0 px-7 py-3 rounded-full bg-white border border-gray-300 text-xs font-black" data-filter="<?= strtolower($destino) ?>">
                            <?= $destino ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div id="cardsGrid" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 mt-2">
                    <?php foreach ($yates as $yate): ?>
                        <article class="yachtCard bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="relative h-48 overflow-hidden">
                                <img src="<?= $yate["imagen"] ?>" alt="<?= $yate["titulo"] ?>" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                                <span class="absolute top-4 left-4 bg-tealDark text-white text-xs font-black px-4 py-2 rounded-full">
                                    <?= $yate["descuento"] ?>
                                </span>
                                <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white flex items-center justify-center text-tealDark shadow">
                                    ♡
                                </button>
                            </div>

                            <div class="p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="font-black text-lg"><?= $yate["titulo"] ?></h3>
                                    <span class="bg-cream text-tealDark px-2 py-1 rounded-md text-xs font-black">
                                        ⭐ <?= $yate["rating"] ?>
                                    </span>
                                </div>

                                <div class="mt-4 space-y-2 text-sm text-gray-500 font-medium">
                                    <p>⚓ <?= $yate["personas"] ?></p>
                                    <p>🕒 <?= $yate["duracion"] ?></p>
                                    <p>📅 <?= $yate["fecha"] ?></p>
                                </div>

                                <div class="mt-5 text-center">
                                    <p class="text-gray-400 line-through text-sm"><?= $yate["precio_antiguo"] ?> MAD</p>
                                    <p class="text-2xl font-black text-tealDark">
                                        <?= $yate["precio"] ?> MAD
                                    </p>
                                    <p class="text-xs text-gray-500">por hora desde</p>
                                </div>

                                <a href="https://wa.me/<?= $whatsapp ?>" class="block text-center border border-gray-300 hover:bg-teal hover:text-white hover:border-teal transition rounded-md py-3 mt-5 font-black text-sm">
                                    Enquire Now
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

    </section>

</div>

<section id="contacto" class="max-w-[1420px] mx-auto px-4 md:px-8 pb-8">
    <div class="bg-tealDark rounded-[2rem] text-white p-8 md:p-12 shadow-soft">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <p class="text-teal font-black uppercase tracking-[0.3em] text-sm">Marina Smir</p>
                <h2 class="font-title text-4xl md:text-6xl mt-3">
                    Reserva tu salida en yate
                </h2>
                <p class="text-white/70 mt-5 max-w-xl">
                    Página temporal para presentar el servicio mientras se prepara la web oficial de alquiler de yates.
                </p>
            </div>

            <form id="bookingForm" class="bg-white text-tealDark rounded-2xl p-6 grid gap-4">
                <input id="name" type="text" placeholder="Nombre completo" class="border border-gray-200 rounded-xl px-4 py-4 outline-none focus:border-teal">
                <input id="phone" type="tel" placeholder="Teléfono" class="border border-gray-200 rounded-xl px-4 py-4 outline-none focus:border-teal">
                <select id="boatType" class="border border-gray-200 rounded-xl px-4 py-4 outline-none focus:border-teal">
                    <option value="">Tipo de yate</option>
                    <option>Yate pequeño</option>
                    <option>Yate mediano</option>
                    <option>No estoy seguro</option>
                </select>
                <button class="bg-teal hover:bg-tealDark text-white rounded-xl py-4 font-black transition">
                    Enviar por WhatsApp
                </button>
                <p id="formMsg" class="hidden text-sm font-bold"></p>
            </form>
        </div>
    </div>
</section>

<script src="assets/js/app.js"></script>

</body>
</html>