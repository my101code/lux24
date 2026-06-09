<?php
$lang = $lang ?? 'es';
$pageTitle = $pageTitle ?? 'Lux24';
$metaDescription = $metaDescription ?? '';
$bodyClass = $bodyClass ?? '';
$headLinks = $headLinks ?? [];
$headStyles = $headStyles ?? [];
$headScripts = $headScripts ?? [];
$inlineHeadScripts = $inlineHeadScripts ?? [];
$inlineHeadStyles = $inlineHeadStyles ?? [];
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <?php if ($metaDescription !== ''): ?>
        <meta name="description" content="<?= e($metaDescription) ?>">
    <?php endif; ?>

    <?php foreach ($headStyles as $styleHref): ?>
        <link rel="stylesheet" href="<?= e($styleHref) ?>">
    <?php endforeach; ?>

    <?php foreach ($headLinks as $link): ?>
        <link <?= $link ?> >
    <?php endforeach; ?>

    <?php foreach ($headScripts as $scriptSrc): ?>
        <script src="<?= e($scriptSrc) ?>"></script>
    <?php endforeach; ?>

    <?php foreach ($inlineHeadStyles as $inlineStyle): ?>
        <style>
<?= $inlineStyle ?>
        </style>
    <?php endforeach; ?>

    <?php foreach ($inlineHeadScripts as $inlineScript): ?>
        <script>
<?= $inlineScript ?>
        </script>
    <?php endforeach; ?>
</head>
<body class="<?= e($bodyClass) ?>">