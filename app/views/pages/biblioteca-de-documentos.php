<?php
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
$libraryMenu = [
    ['fa-user-tie','Mi Perfil','mi-perfil/'], ['fa-id-card','Credencial Digital','credencial-digital/'],
    ['fa-book','Comentarios de la NOM','comentarios-de-la-nom/'], ['fa-file','Biblioteca de Documentos','biblioteca-de-documentos/'],
    ['fa-file','Documentos Consejo Directivo','documentos-consejo-directivo/'], ['fa-check-square','Solicitud de Formatos/Portadas','solicitud-formatos-portadas/'],
    ['fa-users','Directorio de Asociados Extendido','directorio-asociados-extendido/'], ['fa-cog','Aranceles','aranceles/'], ['fa-envelope','Enviar Mensaje','enviar-mensaje/'],
];
$documents = [];
foreach ((require dirname(__DIR__, 2) . '/data/information-documents.php') as $document) {
    $relativePath = 'assets/documents/informacion/' . $document['file'];
    if (is_file(dirname(__DIR__, 3) . '/' . $relativePath)) {
        $documents[] = ['title' => $document['title'], 'code' => $document['code'], 'path' => $relativePath];
    }
}
$rootDocuments = glob(dirname(__DIR__, 3) . '/assets/documents/*.pdf') ?: [];
foreach ($rootDocuments as $file) {
    $filename = basename($file);
    $documents[] = [
        'title' => ucwords(str_replace('-', ' ', pathinfo($filename, PATHINFO_FILENAME))),
        'code' => 'Documento AMUVIE',
        'path' => 'assets/documents/' . $filename,
    ];
}
?>
<header class="member-topbar"><div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div><form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form><time class="member-clock" data-member-clock><?= date('H : i : s') ?></time></header>
<div class="member-shell library-shell">
    <aside class="member-sidebar"><a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a><nav><?php foreach ($libraryMenu as [$icon,$label,$url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Biblioteca de Documentos' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav></aside>
    <main class="library-page">
        <h1>Biblioteca de Documentos</h1>
        <div class="library-tools"><label for="library-search"><i class="fas fa-search"></i><span class="sr-only">Buscar documentos</span></label><input id="library-search" type="search" placeholder="Buscar por título o clave…" data-library-search><span data-library-count><?= count($documents) ?> documentos</span></div>
        <div class="library-grid" data-library-grid>
            <?php foreach ($documents as $document): ?>
                <article class="library-document" data-library-document data-search="<?= $safe(mb_strtolower($document['title'] . ' ' . $document['code'], 'UTF-8')) ?>">
                    <a href="<?= $safe(site_url($document['path'])) ?>" target="_blank" rel="noopener" aria-label="Abrir <?= $safe($document['title']) ?>">
                        <img src="<?= $safe(site_url('assets/images/icono-documento-pdf.png')) ?>" alt="" aria-hidden="true">
                        <h2><?= $safe($document['title']) ?></h2>
                        <small><?= $safe($document['code']) ?></small>
                        <span><i class="fas fa-external-link-alt"></i> Abrir PDF</span>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
        <p class="library-empty" data-library-empty hidden>No se encontraron documentos con ese criterio.</p>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
