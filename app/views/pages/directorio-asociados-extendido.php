<?php
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
$directoryMenu = [
    ['fa-user-tie','Mi Perfil','mi-perfil/'], ['fa-id-card','Credencial Digital','credencial-digital/'],
    ['fa-book','Comentarios de la NOM','comentarios-de-la-nom/'], ['fa-file','Biblioteca de Documentos','biblioteca-de-documentos/'],
    ['fa-file','Documentos Consejo Directivo','documentos-consejo-directivo/'], ['fa-check-square','Solicitud de Formatos/Portadas','solicitud-formatos-portadas/'],
    ['fa-users','Directorio de Asociados Extendido','directorio-asociados-extendido/'], ['fa-cog','Aranceles','aranceles/'], ['fa-envelope','Enviar Mensaje','enviar-mensaje/'],
];
if (in_array('administrador', $sessionUser['roles'] ?? [], true)) {
    $directoryMenu[] = ['fa-arrow-left', 'Regresar al panel administrativo', 'administracion/'];
}
$associates = require dirname(__DIR__, 2) . '/data/associates.php';
$avatarColors = ['#275d79','#6e8146','#a75f38','#6d5590','#3f7d6b','#9a4756'];
?>
<header class="member-topbar"><div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div><form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form><time class="member-clock" data-member-clock><?= date('H : i : s') ?></time></header>
<div class="member-shell directory-shell">
    <aside class="member-sidebar"><a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a><nav><?php foreach ($directoryMenu as [$icon,$label,$url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Directorio de Asociados Extendido' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav></aside>
    <main class="extended-directory-page">
        <h1>Directorio de Asociados Extendido</h1>
        <div class="extended-directory-tools"><label for="extended-associates-search"><i class="fas fa-search"></i> Buscar asociado</label><input id="extended-associates-search" type="search" placeholder="Nombre, empresa o correo…" data-associates-search autocomplete="off"><span data-associates-results><?= count($associates) ?> asociados</span></div>
        <div class="extended-directory-table-wrap">
            <table class="extended-directory-table">
                <thead><tr><th>Foto</th><th>Nombre</th><th>Empresa / Unidad de Verificación</th><th>Ciudad</th><th>Estado</th><th>Teléfono</th><th>Celular</th><th>Correo electrónico</th></tr></thead>
                <tbody>
                    <?php foreach ($associates as $index => $associate):
                        $parts = array_map('trim', preg_split('/\s*\/\s*/', $associate['name'], 2) ?: []);
                        $name = $parts[0] ?? $associate['name'];
                        $company = $parts[1] ?? 'Unidad de Verificación independiente';
                        $words = preg_split('/\s+/', $name) ?: [];
                        $initials = mb_substr($words[0] ?? 'A', 0, 1) . mb_substr($words[1] ?? '', 0, 1);
                    ?>
                    <tr data-associate-row>
                        <td data-label="Foto"><span class="associate-avatar" style="--avatar-color:<?= $safe($avatarColors[$index % count($avatarColors)]) ?>"><?= $safe(mb_strtoupper($initials, 'UTF-8')) ?></span></td>
                        <td data-label="Nombre"><strong><?= $safe($name) ?></strong></td>
                        <td data-label="Empresa / Unidad"><?= $safe($company) ?></td>
                        <td data-label="Ciudad">—</td><td data-label="Estado">—</td><td data-label="Teléfono">—</td><td data-label="Celular">—</td>
                        <td data-label="Correo electrónico"><?= $safe($associate['email']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="extended-directory-empty" data-associates-empty hidden><td colspan="8">No se encontraron asociados con ese criterio.</td></tr>
                </tbody>
            </table>
        </div>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
