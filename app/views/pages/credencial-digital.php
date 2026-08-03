<?php
$displayName = trim((string) ($profile['public_name'] ?: $sessionUser['full_name'] ?: $sessionUser['username']));
$photoUrl = !empty($profile['photo_path']) ? site_url($profile['photo_path']) : null;
$credentialMenu = [
    ['fa-user-tie', 'Mi Perfil', 'mi-perfil/'], ['fa-id-card', 'Credencial Digital', 'credencial-digital/'],
    ['fa-book', 'Comentarios de la NOM', 'comentarios-de-la-nom/'], ['fa-file', 'Biblioteca de Documentos', 'biblioteca-de-documentos/'],
    ['fa-file', 'Documentos Consejo Directivo', 'documentos-consejo-directivo/'], ['fa-check-square', 'Solicitud de Formatos/Portadas', 'solicitud-formatos-portadas/'],
    ['fa-users', 'Directorio de Asociados Extendido', 'directorio-asociados-extendido/'], ['fa-cog', 'Aranceles', 'aranceles/'], ['fa-envelope', 'Enviar Mensaje', 'enviar-mensaje/'],
];
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
?>
<header class="member-topbar">
    <div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div>
    <form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form>
    <time class="member-clock" data-member-clock><?= date('H : i : s') ?></time>
</header>
<div class="member-shell credential-shell">
    <aside class="member-sidebar">
        <a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a>
        <nav><?php foreach ($credentialMenu as [$icon, $label, $url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Credencial Digital' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav>
    </aside>
    <main class="credential-page">
        <article class="digital-card" id="digital-credential">
            <div class="digital-card__corner"></div>
            <img class="digital-card__logo" src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE">
            <h1>ASOCIACIÓN MEXICANA DE UNIDADES DE VERIFICACIÓN,<br>INSPECCIÓN Y ESTANDARIZACIÓN A.C.</h1>
            <div class="digital-card__identity">
                <div class="digital-card__portrait">
                    <?php if ($photoUrl): ?><img src="<?= $safe($photoUrl) ?>" alt="Fotografía de <?= $safe($displayName) ?>"><?php else: ?><i class="fas fa-user"></i><?php endif; ?>
                </div>
                <div><h2><?= $safe(mb_strtoupper($displayName, 'UTF-8')) ?></h2><p>MIEMBRO ASOCIADO AMUVIE VIGENTE <?= date('Y') ?></p></div>
            </div>
            <div class="digital-card__data">
                <div class="credential-qr" data-credential-qr data-qr-value="<?= $safe($sessionUser['username'] . '|' . $displayName . '|' . ($profile['email'] ?? '')) ?>" aria-label="Código identificador de la credencial"></div>
                <ul>
                    <li><i class="fas fa-phone"></i><?= $safe($profile['phone'] ?: 'Sin teléfono') ?></li>
                    <li><i class="fas fa-mobile-alt"></i><?= $safe($profile['business_phone'] ?: $profile['mobile'] ?: 'Sin celular') ?></li>
                    <li><i class="fab fa-whatsapp"></i><?= $safe($profile['mobile'] ?: 'Sin celular') ?></li>
                </ul>
                <ul>
                    <li><i class="fas fa-envelope"></i><?= $safe($profile['email']) ?></li>
                    <li><i class="fas fa-building"></i><?= $safe($profile['company'] ?: 'Sin empresa') ?></li>
                    <li><i class="fas fa-globe"></i><?= $safe($profile['website'] ?: 'Sin sitio web') ?></li>
                </ul>
            </div>
            <div class="digital-card__bottom">
                <span><i class="fas fa-phone"></i> 332 5287 852</span><span><i class="fas fa-envelope"></i> admin@amuvie.mx</span><span><i class="fas fa-external-link-square-alt"></i> www.amuvie.mx</span>
                <strong>PATROCINADORES OFICIALES</strong><img src="<?= $safe(site_url('assets/images/logo-ema.png')) ?>" alt="ema"><img src="<?= $safe(site_url('assets/images/logo-ance.png')) ?>" alt="ANCE">
            </div>
        </article>
        <button class="credential-download" type="button" data-download-credential data-download-name="credencial-amuvie-<?= $safe($sessionUser['username']) ?>.png"><i class="fas fa-download"></i> Descargar Credencial</button>
        <p class="credential-download-status" data-credential-download-status role="status" aria-live="polite"></p>
        <p class="credential-help">La credencial utiliza automáticamente la información y fotografía guardadas en “Mi perfil”.</p>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
