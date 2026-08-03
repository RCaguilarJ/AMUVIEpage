<?php
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
$commentMenu = [
    ['fa-user-tie','Mi Perfil','mi-perfil/'], ['fa-id-card','Credencial Digital','credencial-digital/'],
    ['fa-book','Comentarios de la NOM','comentarios-de-la-nom/'], ['fa-file','Biblioteca de Documentos','biblioteca-de-documentos/'],
    ['fa-file','Documentos Consejo Directivo','documentos-consejo-directivo/'], ['fa-check-square','Solicitud de Formatos/Portadas','solicitud-formatos-portadas/'],
    ['fa-users','Directorio de Asociados Extendido','directorio-asociados-extendido/'], ['fa-cog','Aranceles','aranceles/'], ['fa-envelope','Enviar Mensaje','enviar-mensaje/'],
];
$albercas = ['Comentario Gradiente de Potencial','COMENTARIO PUENTE DE UNIÓN EQUIPOTENCIAL'];
$articulo110 = ['Artículo, parte 1 110','Artículo, parte 2 110','COMENTARIO Sección 110-41 NUEVA','INTRODUCCIÓN 110'];
$leftComments = ['ARTÍCULO 200','220-14 i) SALIDAS DE CONTACTOS','250-122 d) cable de tierra de motores','ARTÍCULO 100','Capítulo 1 general','COMENTARIO 300-3 c) 2) y 392-20','COMENTARIO 300-20 CORRIENTES INDUCIDAS EN ENVOLVENTES O CANALIZACIONES METÁLICAS','COMENTARIO 310-10-h','COMENTARIO 517-19 ÁREAS DE ATENCIÓN CRÍTICA','COMENTARIO ARTÍCULO 200','COMENTARIO ARTÍCULO 240-24 c), d), e), f)','COMENTARIO ARTÍCULO 690','COMENTARIO SECCIÓN 250-122 b)'];
$rightComments = ['COMENTARIO SECCIÓN 300-7 a) y b)','COMENTARIO SOBRE LOS INTERRUPTORES DE CIRCUITO DE FALLA A TIERRA GFCI','COMENTARIO VARILLA ES DE 3 METROS','COMENTARIOS ARTÍCULO 210 COMPLETO','CORRIENTES INDESEABLES','CURRICULUM JLOM','DEFINICIONES ACCESIBLE','Es un área peligrosa (Clasificada)','PUENTE DE UNIÓN 250-24','PUENTE DE UNIÓN DEL SISTEMA Y PUENTE DE UNIÓN PRINCIPAL','PUESTA A TIERRA EN ADEME METÁLICO DE POZOS','SECCIÓN 250-24 b)'];
$poolDocuments = ['Aclaración 1, 2 Y 3 ANATOMÍA DE INSTALACIONES','ARTÍCULO 506 zonas 20, 21 y 22, Taller de carpintería','Comentario 110-14 a)','COMENTARIO SECCIÓN 300-3 a) y b)','SECCIÓN 501-15','SECCIÓN 250-24 b)','CORRIENTES INDUCIDAS EN ENVOLVENTES O CANALIZACIONES METÁLICAS','EQUIPOTENCIALES Y UNIÓN DE PLANOS EQUIPOTENCIALES EN EDIFICIOS AGRÍCOLAS','Bombas contra incendio, cálculos en profundidad','Listas de verificación, fundamentos NOM','ALBERCAS, FUENTES E INSTALACIONES SIMILARES AMUVIE','Lista de INSPECCIÓN 1 Albercas permanentes. Inspección inicial antes del vertido de hormigón o entierro','Lista de INSPECCIÓN 2 - PARTE B Albercas permanentes. Inspecciones intermedias y finales','Lista de INSPECCIÓN 3 - PARTE C Albercas desmontables, jacuzzis desmontables y bañeras térmicas desmontables','Lista de INSPECCIÓN 4 - PARTE D Albercas y tinas de hidromasaje. Todas las instalaciones','Lista de INSPECCIÓN 5 - PARTE D Albercas y tinas de hidromasaje. Solo instalaciones interiores','Lista de INSPECCIÓN 6 - PARTE E Fuentes','Lista de INSPECCIÓN 7 - PARTE F Albercas y tinas para uso terapéutico','Lista de INSPECCIÓN 8 - PARTE G Tinas de hidromasaje','Lista de INSPECCIÓN 9 - PARTE H Sillas salvaescaleras eléctricas para alberca'];
$nomFiles = require __DIR__ . '/../../data/nom-document-files.php';
$nomFileIndex = 0;
$renderList = static function (array $items) use ($safe, $nomFiles, &$nomFileIndex): void {
    echo '<ul class="nom-list">';
    foreach ($items as $item) {
        $file = $nomFiles[$nomFileIndex++] ?? null;
        if ($file === null) continue;
        echo '<li><a href="' . $safe(site_url('assets/documents/comentarios-nom/' . rawurlencode($file))) . '" download>' . $safe($item) . '</a></li>';
    }
    echo '</ul>';
};
?>
<header class="member-topbar"><div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div><form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form><time class="member-clock" data-member-clock><?= date('H : i : s') ?></time></header>
<div class="member-shell nom-shell">
    <aside class="member-sidebar"><a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a><nav><?php foreach ($commentMenu as [$icon,$label,$url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Comentarios de la NOM' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav></aside>
    <main class="nom-page">
        <h1>Comentarios de la NOM</h1>
        <section class="nom-featured"><div><h2>ALBERCAS</h2><?php $renderList($albercas); ?></div><div><h2>ARTÍCULO 110</h2><?php $renderList($articulo110); ?></div></section>
        <section class="nom-columns"><div><?php $renderList($leftComments); ?></div><div><?php $renderList($rightComments); ?></div></section>
        <section class="nom-pool-documents"><?php $renderList($poolDocuments); ?></section>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
