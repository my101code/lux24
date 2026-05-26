<?php
$empresa = "Lux24 Yates";

$yates = [
	[
		"nombre" => "Aquila 42 Mirage",
		"descripcion" => "Ideal para una escapada elegante por la costa con hasta 10 invitados.",
		"capacidad" => "10 personas",
		"duracion" => "4-8 horas",
		"precio" => "1.250 MAD / hora",
		"imagen" => "https://images.unsplash.com/photo-1569263979104-865ab7cd8d13?auto=format&fit=crop&w=1200&q=80"
	],
	[
		"nombre" => "Sunseeker Wave",
		"descripcion" => "Navegacion premium para celebraciones privadas y atardeceres inolvidables.",
		"capacidad" => "12 personas",
		"duracion" => "Medio dia",
		"precio" => "1.600 MAD / hora",
		"imagen" => "https://images.unsplash.com/photo-1567899378494-47b22a2ae96a?auto=format&fit=crop&w=1200&q=80"
	],
	[
		"nombre" => "Lagoon Serenity",
		"descripcion" => "Perfecto para familias que buscan comodidad, musica y vistas abiertas.",
		"capacidad" => "8 personas",
		"duracion" => "3-6 horas",
		"precio" => "980 MAD / hora",
		"imagen" => "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80"
	],
	[
		"nombre" => "Ocean Pearl 50",
		"descripcion" => "Diseno deportivo con zonas lounge y servicio para eventos exclusivos.",
		"capacidad" => "14 personas",
		"duracion" => "Jornada completa",
		"precio" => "2.100 MAD / hora",
		"imagen" => "https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80"
	],
	[
		"nombre" => "Blue Horizon",
		"descripcion" => "Yate de lujo para rutas fotografias, relax y snorkel en aguas tranquilas.",
		"capacidad" => "9 personas",
		"duracion" => "5 horas",
		"precio" => "1.150 MAD / hora",
		"imagen" => "https://images.unsplash.com/photo-1605281317010-fe5ffe798166?auto=format&fit=crop&w=1200&q=80"
	],
	[
		"nombre" => "Marina Royal",
		"descripcion" => "Experiencia VIP con tripulacion profesional y ambiente sofisticado.",
		"capacidad" => "16 personas",
		"duracion" => "8 horas",
		"precio" => "2.450 MAD / hora",
		"imagen" => "https://images.unsplash.com/photo-1528154291023-a6525fabe5b4?auto=format&fit=crop&w=1200&q=80"
	]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $empresa ?> | Nuestros Yates</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;900&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
	<script>
		tailwind.config = {
			theme: {
				extend: {
					colors: {
						brandNavy: "#08283A",
						brandSea: "#0E7490",
						brandSand: "#F3DFC1"
					},
					fontFamily: {
						title: ["Cinzel", "serif"],
						body: ["Manrope", "sans-serif"]
					},
					boxShadow: {
						card: "0 20px 35px rgba(7, 32, 46, 0.18)"
					}
				}
			}
		};
	</script>
	<style>
		.hero-title {
			animation: floatingTitle 4.2s ease-in-out infinite;
		}

		@keyframes floatingTitle {
			0%,
			100% {
				transform: translateY(0);
			}
			50% {
				transform: translateY(-5px);
			}
		}

		.swiper-button-disabled {
			opacity: 0.4;
			cursor: not-allowed;
		}
	</style>
</head>
<body class="font-body text-slate-800 bg-gradient-to-b from-sky-50 via-slate-50 to-white">

<header class="relative min-h-[70vh] overflow-hidden">
	<img
		class="absolute inset-0 h-full w-full object-cover scale-105"
		src="https://images.unsplash.com/photo-1540946485063-a40da27545f8?auto=format&fit=crop&w=1900&q=80"
		alt="Yate de lujo navegando"
	>
	<div class="absolute inset-0 bg-gradient-to-r from-brandNavy/80 via-brandNavy/45 to-cyan-700/50"></div>
	<div class="relative z-10 mx-auto flex min-h-[70vh] w-[94%] max-w-7xl flex-col items-center justify-center text-center text-white">
		<p class="mb-4 rounded-full border border-white/40 bg-white/15 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.15em]">Experiencias privadas en el mar</p>
		<h1 class="hero-title font-title text-4xl leading-tight sm:text-5xl md:text-6xl">
			Convierte tu proximo dia libre en una travesia de lujo.
			<span class="block text-brandSand">Alquila tu yate hoy.</span>
		</h1>
		<a href="#productos" class="mt-8 rounded-xl border border-white/50 bg-brandSand px-6 py-3 text-sm font-extrabold text-brandNavy transition hover:-translate-y-0.5 hover:shadow-lg">Ver nuestros yates</a>
	</div>
</header>

<main>
	<section id="productos" class="mx-auto -mt-12 w-[95%] max-w-7xl rounded-3xl bg-white/90 p-5 shadow-2xl backdrop-blur-sm sm:p-8">
		<div class="mb-6 flex flex-col gap-3 sm:mb-8 sm:flex-row sm:items-end sm:justify-between">
			<div>
				<h2 class="font-title text-3xl text-brandNavy sm:text-4xl">Nuestros productos</h2>
				<p class="mt-2 max-w-2xl text-sm font-medium text-slate-600 sm:text-base">Desliza de forma suave para explorar nuestros yates disponibles y elegir la experiencia perfecta.</p>
			</div>
			<div class="flex items-center gap-2">
				<button id="prevBtn" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-brandSea text-xl font-black text-white transition hover:bg-brandNavy" aria-label="Ver yates anteriores">&#8592;</button>
				<button id="nextBtn" class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-brandSea text-xl font-black text-white transition hover:bg-brandNavy" aria-label="Ver yates siguientes">&#8594;</button>
			</div>
		</div>

		<div class="swiper" id="cardsSlider">
			<div class="swiper-wrapper">
			<?php foreach ($yates as $yate): ?>
				<article class="swiper-slide overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-card">
					<img class="h-56 w-full object-cover" src="<?= htmlspecialchars($yate['imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($yate['nombre'], ENT_QUOTES, 'UTF-8') ?>">
					<div class="space-y-3 p-5">
						<h3 class="text-lg font-extrabold text-brandNavy"><?= htmlspecialchars($yate['nombre'], ENT_QUOTES, 'UTF-8') ?></h3>
						<p class="min-h-[72px] text-sm leading-relaxed text-slate-600"><?= htmlspecialchars($yate['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
						<div class="flex flex-wrap gap-2 text-xs font-bold">
							<span class="rounded-full bg-cyan-50 px-3 py-1 text-brandSea"><?= htmlspecialchars($yate['capacidad'], ENT_QUOTES, 'UTF-8') ?></span>
							<span class="rounded-full bg-cyan-50 px-3 py-1 text-brandSea"><?= htmlspecialchars($yate['duracion'], ENT_QUOTES, 'UTF-8') ?></span>
						</div>
						<p class="text-base font-black text-brandNavy"><?= htmlspecialchars($yate['precio'], ENT_QUOTES, 'UTF-8') ?></p>
					</div>
				</article>
			<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

const slider = new Swiper("#cardsSlider", {
	speed: 850,
	grabCursor: true,
	spaceBetween: 20,
	loop: true,
	freeMode: {
		enabled: true,
		momentumRatio: 0.45
	},
	autoplay: {
		delay: 2400,
		disableOnInteraction: false
	},
	breakpoints: {
		0: {
			slidesPerView: 1.05
		},
		640: {
			slidesPerView: 2.1
		},
		1024: {
			slidesPerView: 3.05
		},
		1280: {
			slidesPerView: 3.4
		}
	}
});

prevBtn.addEventListener("click", () => slider.slidePrev());
nextBtn.addEventListener("click", () => slider.slideNext());
</script>

</body>
</html>
