<?php
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
$councilMenu = [
    ['fa-user-tie','Mi Perfil','mi-perfil/'], ['fa-id-card','Credencial Digital','credencial-digital/'],
    ['fa-book','Comentarios de la NOM','comentarios-de-la-nom/'], ['fa-file','Biblioteca de Documentos','biblioteca-de-documentos/'],
    ['fa-file','Documentos Consejo Directivo','documentos-consejo-directivo/'], ['fa-check-square','Solicitud de Formatos/Portadas','solicitud-formatos-portadas/'],
    ['fa-users','Directorio de Asociados Extendido','directorio-asociados-extendido/'], ['fa-cog','Aranceles','aranceles/'], ['fa-envelope','Enviar Mensaje','enviar-mensaje/'],
];
if (in_array('administrador', $sessionUser['roles'] ?? [], true)) {
    $councilMenu[] = ['fa-arrow-left', 'Regresar al panel administrativo', 'administracion/'];
}
$councils = [
    ['3.er Consejo Directivo 2018 - 2020', 'tercer-consejo'],
    ['4.º Consejo Directivo 2020 - 2022', 'cuarto-consejo'],
    ['5.º Consejo Directivo 2022 - 2024', 'quinto-consejo'],
];
$actsLeft = ['CONVENIO AMUVIE Y NFPA','ACTA DE ASAMBLEA ORDINARIA 2025 CAMBIO DE TESORERO','CONVENIO NFPA','ESTATUTOS FUNDACIÓN DE LA AMUVIE','ACTA CONSTITUTIVA FUNDADORA AMUVIE 2014','ACTA ASAMBLEA - 2015 - 1','ACTA ASAMBLEA 2014 - 2','ACTA ASAMBLEA 2014 - 3','ACTA ASAMBLEA 2015 - 2','ACTA ASAMBLEA 2020','ACTA CONSTITUTIVA 2021'];
$actsRight = ['ACTA CONSTITUTIVA 2022','ACTA ASAMBLEA 08 JULIO 2015','ACTA ASAMBLEA 17 DIC 2015','CUARTO CONSEJO DIRECTIVO 2020','PRIMER ACTA FUNDACIÓN 2014','QUINTO CONSEJO DIRECTIVO 2022','SEXTO CONSEJO DIRECTIVO 2024','TERCER CONSEJO DIRECTIVO 2018','ACTA DE ASAMBLEA REFORMA DE ESTATUTOS 2024'];
$precursorsLeft = ['RESUMEN DE CONCLUSIONES - CONCENTRADO RNUV 2013','M1','M2','M3','M4'];
$precursorsRight = ['M5','M6','M7','M8','M9'];
$libraryUrl = site_url('biblioteca-de-documentos/');
require_once dirname(__DIR__, 2) . '/documents.php';
$managedCouncilDocuments = publishedDocuments('consejo-directivo');
$renderCouncilList = static function (array $items) use ($safe, $libraryUrl): void {
    echo '<ul class="council-list">';
    foreach ($items as $item) echo '<li><a href="' . $safe($libraryUrl) . '">' . $safe($item) . '</a></li>';
    echo '</ul>';
};
?>
<header class="member-topbar"><div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div><form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form><time class="member-clock" data-member-clock><?= date('H : i : s') ?></time></header>
<div class="member-shell council-shell">
    <aside class="member-sidebar"><a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a><nav><?php foreach ($councilMenu as [$icon,$label,$url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Documentos Consejo Directivo' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav></aside>
    <main class="council-page">
        <h1>Documentos Consejo Directivo</h1>
        <section class="council-folders" aria-label="Consejos directivos">
            <?php foreach ($councils as [$label,$target]): ?><a href="#<?= $safe($target) ?>"><span class="council-folder"><i class="fas fa-file-alt"></i></span><strong><?= $safe($label) ?></strong></a><?php endforeach; ?>
        </section>
        <section class="council-section" id="actas-estatutos"><h2>Actas y Estatutos</h2><div class="council-columns"><div id="tercer-consejo"><?php $renderCouncilList($actsLeft); ?></div><div id="cuarto-consejo"><?php $renderCouncilList($actsRight); ?></div></div><span id="quinto-consejo"></span></section>
        <section class="council-section council-precursors"><h2>Documentos precursores de AMUVIE</h2><div class="council-columns"><div><?php $renderCouncilList($precursorsLeft); ?></div><div><?php $renderCouncilList($precursorsRight); ?></div></div></section>
        <?php if ($managedCouncilDocuments): ?><section class="council-section"><h2>Documentos agregados</h2><ul class="council-list"><?php foreach ($managedCouncilDocuments as $document): ?><li><a href="<?= $safe(site_url($document['stored_path'])) ?>" download><?= $safe($document['title']) ?></a></li><?php endforeach; ?></ul></section><?php endif; ?>
        <p class="council-note"><i class="fas fa-info-circle"></i> Los documentos disponibles se consultan desde la Biblioteca de Documentos.</p>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
