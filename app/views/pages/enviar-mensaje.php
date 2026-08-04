<?php
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
$messageMenu = [
    ['fa-user-tie','Mi Perfil','mi-perfil/'], ['fa-id-card','Credencial Digital','credencial-digital/'],
    ['fa-book','Comentarios de la NOM','comentarios-de-la-nom/'], ['fa-file','Biblioteca de Documentos','biblioteca-de-documentos/'],
    ['fa-file','Documentos Consejo Directivo','documentos-consejo-directivo/'], ['fa-check-square','Solicitud de Formatos/Portadas','solicitud-formatos-portadas/'],
    ['fa-users','Directorio de Asociados Extendido','directorio-asociados-extendido/'], ['fa-cog','Aranceles','aranceles/'], ['fa-envelope','Enviar Mensaje','enviar-mensaje/'],
];
if (in_array('administrador', $sessionUser['roles'] ?? [], true)) {
    $messageMenu[] = ['fa-arrow-left', 'Regresar al panel administrativo', 'administracion/'];
}
$categories = ['administracion'=>'Administración','soporte'=>'Soporte del portal','facturacion'=>'Facturación','formatos'=>'Formatos y portadas','directorio'=>'Directorio de asociados','otro'=>'Otro asunto'];
?>
<header class="member-topbar"><div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div><form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form><time class="member-clock" data-member-clock><?= date('H : i : s') ?></time></header>
<div class="member-shell message-shell">
    <aside class="member-sidebar"><a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a><nav><?php foreach ($messageMenu as [$icon,$label,$url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Enviar Mensaje' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav></aside>
    <main class="message-page">
        <h1>Enviar mensaje</h1>
        <?php if ($messageError): ?><p class="profile-message profile-message--error" role="alert"><?= $safe($messageError) ?></p><?php endif; ?>
        <?php if ($messageSuccess): ?><p class="profile-message profile-message--success" role="status"><?= $safe($messageSuccess) ?></p><?php endif; ?>
        <form class="member-message-form" method="post">
            <input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>">
            <div class="member-message-form__names"><label><span>Nombre(s)</span><input name="first_name" maxlength="100" value="<?= $safe($profile['first_name'] ?: '') ?>" required></label><label><span>Apellidos</span><input name="last_name" maxlength="120" value="<?= $safe($profile['last_name'] ?: '') ?>" required></label></div>
            <label><span>Correo electrónico</span><input type="email" name="email" maxlength="190" value="<?= $safe($profile['email']) ?>" required></label>
            <label><span>Selecciona una opción <b>*</b></span><select name="category" required><option value="">Selecciona una opción</option><?php foreach ($categories as $value=>$label): ?><option value="<?= $safe($value) ?>"><?= $safe($label) ?></option><?php endforeach; ?></select></label>
            <label><span>Escribe tus comentarios <b>*</b></span><textarea name="message" rows="7" minlength="10" maxlength="5000" required></textarea><small>Máximo 5,000 caracteres.</small></label>
            <button type="submit">Enviar mensaje</button>
        </form>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
