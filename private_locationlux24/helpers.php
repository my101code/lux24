<?php
declare(strict_types=1);

if (!defined('APP_ROOT')) {
	define('APP_ROOT', dirname(__DIR__));
}

if (!defined('PARTIALS_DIR')) {
	define('PARTIALS_DIR', APP_ROOT . DIRECTORY_SEPARATOR . 'private_locationlux24' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'partials');
}

if (!function_exists('render_partial')) {
	function render_partial(string $name, array $vars = []): void
	{
		$file = PARTIALS_DIR . DIRECTORY_SEPARATOR . $name . '.php';

		if (!is_file($file)) {
			throw new RuntimeException('Partial not found: ' . $name);
		}

		extract($vars, EXTR_SKIP);
		require $file;
	}
}

if (!function_exists('e')) {
	function e(string $value): string
	{
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
}
