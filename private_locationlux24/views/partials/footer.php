<?php
$pageScripts = $pageScripts ?? [];
$inlineScripts = $inlineScripts ?? [];
?>
<?php foreach ($pageScripts as $scriptSrc): ?>
    <script src="<?= e($scriptSrc) ?>"></script>
<?php endforeach; ?>

<?php foreach ($inlineScripts as $inlineScript): ?>
    <script>
<?= $inlineScript ?>
    </script>
<?php endforeach; ?>

</body>
</html>
