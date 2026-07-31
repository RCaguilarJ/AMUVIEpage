<?php
$safe = static fn(mixed $text): string => htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
$requestMenu = [
    ['fa-user-tie','Mi Perfil','mi-perfil/'], ['fa-id-card','Credencial Digital','credencial-digital/'],
    ['fa-book','Comentarios de la NOM','comentarios-de-la-nom/'], ['fa-file','Biblioteca de Documentos','biblioteca-de-documentos/'],
    ['fa-file','Documentos Consejo Directivo','documentos-consejo-directivo/'], ['fa-check-square','Solicitud de Formatos/Portadas','solicitud-formatos-portadas/'],
    ['fa-users','Directorio de Asociados Extendido','directorio-asociados-extendido/'], ['fa-cog','Aranceles','aranceles/'], ['fa-envelope','Enviar Mensaje','enviar-mensaje/'],
];
$formatOptions = ['Portada NOM-001-SEDE','Portada NOM-007-ENER','Portada NOM-013-ENER','Portada personalizada AMUVIE'];
?>
<header class="member-topbar"><div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?></div><form method="post"><input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form><time class="member-clock" data-member-clock><?= date('H : i : s') ?></time></header>
<div class="member-shell request-shell">
    <aside class="member-sidebar"><a class="member-sidebar__logo" href="<?= $safe(site_url('inicio/')) ?>"><img src="<?= $safe(site_url('assets/images/logoamuvieblanco.png')) ?>" alt="AMUVIE A.C."></a><nav><?php foreach ($requestMenu as [$icon,$label,$url]): ?><a href="<?= $url === '#' ? '#' : $safe(site_url($url)) ?>" class="<?= $label === 'Solicitud de Formatos/Portadas' ? 'is-active' : '' ?>"><i class="fas <?= $safe($icon) ?>"></i><span><?= $safe($label) ?></span></a><?php endforeach; ?></nav></aside>
    <main class="request-page">
        <h1>Solicitud de Formatos de Portadas</h1>
        <?php if ($requestError): ?><p class="profile-message profile-message--error" role="alert"><?= $safe($requestError) ?></p><?php endif; ?>
        <?php if ($requestSuccess): ?><p class="profile-message profile-message--success" role="status"><?= $safe($requestSuccess) ?></p><?php endif; ?>
        <form class="format-request-form" method="post" enctype="multipart/form-data" data-format-request>
            <input type="hidden" name="csrf_token" value="<?= $safe($_SESSION['csrf_token']) ?>">
            <h2>Datos de la Unidad de Verificación</h2>
            <div class="request-main-fields">
                <label><span>Nombre <b>*</b></span><input name="applicant_name" value="<?= $safe($sessionUser['full_name'] ?: $sessionUser['username']) ?>" required></label>
                <fieldset><legend>Selecciona una opción <b>*</b></legend><label><input type="radio" name="delivery_type" value="digital" data-delivery-price="0" required> Digital</label><label><input type="radio" name="delivery_type" value="envio" data-delivery-price="250"> Con envío</label></fieldset>
                <fieldset><legend>¿Requiere factura? <b>*</b></legend><label><input type="radio" name="requires_invoice" value="1" required> Sí</label><label><input type="radio" name="requires_invoice" value="0"> No</label></fieldset>
            </div>
            <h2>Selección de Formatos</h2>
            <div class="format-options"><?php foreach ($formatOptions as $format): ?><label><input type="checkbox" name="formats[]" value="<?= $safe($format) ?>"> <span><?= $safe($format) ?></span></label><?php endforeach; ?></div>
            <label class="request-upload"><span>Adjunte su Comprobante de Pago y su Aprobación Vigente <b>*</b></span><span class="request-dropzone"><i class="fas fa-upload"></i><strong data-upload-label>Suelta archivos aquí o haz clic para subir</strong><small>PDF, JPG o PNG. Máximo 10 MB por archivo.</small><input type="file" name="attachments[]" accept="application/pdf,image/jpeg,image/png" multiple required data-request-files></span></label>
            <p class="request-contact">Si tiene alguna duda o comentario, envíenos un correo electrónico a <a href="mailto:admin@amuvie.mx">admin@amuvie.mx</a> o llame al 01 (378) 132-1506, celular 332 5287 852.</p>
            <div class="request-notes"><strong>NOTAS:</strong><p>* Solo se atenderán solicitudes de Unidades de Verificación con aprobación vigente publicadas en el padrón de verificadores de SENER y CONUEE.</p><p>* La solicitud deberá llenarse con todos los campos requeridos.</p><p>* El comprobante de depósito o transferencia y la aprobación vigente deben adjuntarse a esta solicitud.</p><p>* Para aclaraciones: admin@amuvie.mx.</p></div>
            <div class="request-total"><h2>Total a Pagar</h2><strong data-request-total>$0.00</strong></div>
            <button class="request-submit" type="submit">Enviar Solicitud</button>
        </form>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
