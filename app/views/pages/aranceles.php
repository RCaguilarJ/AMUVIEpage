<?php
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
$tariffMenu = [
    ['fa-user-tie','Mi Perfil','mi-perfil/'], ['fa-id-card','Credencial Digital','credencial-digital/'],
    ['fa-book','Comentarios de la NOM','comentarios-de-la-nom/'], ['fa-file','Biblioteca de Documentos','biblioteca-de-documentos/'],
    ['fa-file','Documentos Consejo Directivo','documentos-consejo-directivo/'], ['fa-check-square','Solicitud de Formatos/Portadas','solicitud-formatos-portadas/'],
    ['fa-users','Directorio de Asociados Extendido','directorio-asociados-extendido/'], ['fa-cog','Aranceles','aranceles/'], ['fa-envelope','Enviar Mensaje','enviar-mensaje/'],
];
$services = ['Baja Tensión hasta 25 kW','Ampliación de Carga en kW','Capacidad de la Subestación en kVA','Gasolineras o Lugares de atención a la salud'];
$ranges = ['0 a 25 km','26 a 50 km','51 a 100 km','101 a 200 km','Más de 200 km'];
?>
<header class="member-topbar"><div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div><form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form><time class="member-clock" data-member-clock><?= date('H : i : s') ?></time></header>
<div class="member-shell tariff-shell">
    <aside class="member-sidebar"><a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a><nav><?php foreach ($tariffMenu as [$icon,$label,$url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Aranceles' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav></aside>
    <main class="tariff-page">
        <section class="tariff-calculator" data-tariff-calculator>
            <h1>Arancel Mínimo Profesional Sugerido</h1>
            <h2>Selecciona una opción</h2>
            <fieldset class="tariff-services"><legend class="sr-only">Tipo de servicio</legend><?php foreach ($services as $service): ?><label><input type="radio" name="tariff_service" value="<?= $safe($service) ?>"> <?= $safe($service) ?></label><?php endforeach; ?></fieldset>
            <div class="tariff-distance"><h2>CARGOS POR DISTANCIAS</h2><label for="tariff-range">Selecciona un rango <b>*</b></label><select id="tariff-range" data-tariff-range><option value="">Selecciona una opción</option><?php foreach ($ranges as $range): ?><option value="<?= $safe($range) ?>"><?= $safe($range) ?></option><?php endforeach; ?></select></div>
            <div class="tariff-summary" data-tariff-summary hidden><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE"><h2>Consulta de arancel sugerido</h2><p><strong>Asociado:</strong> <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></p><p><strong>Servicio:</strong> <span data-summary-service></span></p><p><strong>Distancia:</strong> <span data-summary-range></span></p><small>Documento de consulta. Los importes deben confirmarse contra el arancel SENER vigente.</small></div>
            <div class="tariff-download"><h2>Descargar Aranceles<br>SENER:</h2><button type="button" data-download-tariff disabled><i class="fas fa-download"></i> Descargar Ahora</button></div>
            <p class="tariff-notice"><i class="fas fa-info-circle"></i> El repositorio actual no contiene una tabla oficial de importes. Esta herramienta prepara la selección para consulta y no sustituye el arancel SENER vigente.</p>
        </section>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
