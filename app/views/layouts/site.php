<?php
$isMemberView = isset($memberViews) && in_array($vista, $memberViews, true);
$cssVersion = (string) (filemtime(dirname(__DIR__, 3) . '/assets/css/site.css') ?: time());
$jsVersion = (string) (filemtime(dirname(__DIR__, 3) . '/assets/js/site.js') ?: time());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> | AMUVIE A.C.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= htmlspecialchars(site_url('assets/css/site.css?v=' . $cssVersion), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="view-<?= htmlspecialchars($vista, ENT_QUOTES, 'UTF-8') ?><?= $isMemberView ? ' private-panel' : '' ?>">
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <?php require $viewFile; ?>
    <?php if (!in_array($vista, ['mi-perfil', 'credencial-digital', 'comentarios-de-la-nom', 'biblioteca-de-documentos', 'documentos-consejo-directivo', 'solicitud-formatos-portadas', 'directorio-asociados-extendido', 'aranceles', 'enviar-mensaje', 'administracion'], true)) require __DIR__ . '/../partials/footer.php'; ?>
    <?php if ($vista === 'credencial-digital'): ?><script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script><?php endif; ?>
    <script src="<?= htmlspecialchars(site_url('assets/js/site.js?v=' . $jsVersion), ENT_QUOTES, 'UTF-8') ?>"></script>
</body>
</html>
