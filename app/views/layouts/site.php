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
    <link rel="stylesheet" href="<?= htmlspecialchars(site_url('assets/css/site.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="view-<?= htmlspecialchars($vista, ENT_QUOTES, 'UTF-8') ?>">
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <?php require $viewFile; ?>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
    <script src="<?= htmlspecialchars(site_url('assets/js/site.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
</body>
</html>
