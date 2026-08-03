<?php
$value = static fn(string $key): string => htmlspecialchars((string) ($profile[$key] ?? ''), ENT_QUOTES, 'UTF-8');
$menu = [
    ['fa-user-tie', 'Mi Perfil', 'mi-perfil/'], ['fa-id-card', 'Credencial Digital', 'credencial-digital/'], ['fa-book', 'Comentarios de la NOM', 'comentarios-de-la-nom/'],
    ['fa-file', 'Biblioteca de Documentos', 'biblioteca-de-documentos/'], ['fa-file', 'Documentos Consejo Directivo', 'documentos-consejo-directivo/'],
    ['fa-check-square', 'Solicitud de Formatos/Portadas', 'solicitud-formatos-portadas/'], ['fa-users', 'Directorio de Asociados Extendido', 'directorio-asociados-extendido/'],
    ['fa-cog', 'Aranceles', 'aranceles/'], ['fa-envelope', 'Enviar Mensaje', 'enviar-mensaje/'],
];
?>
<header class="member-topbar">
    <div><i class="fas fa-user-tie"></i> Bienvenido de nuevo, <?= htmlspecialchars($sessionUser['full_name'] ?: $sessionUser['username'], ENT_QUOTES, 'UTF-8') ?></div>
    <form method="post"><input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"><input type="hidden" name="action" value="logout"><button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button></form>
    <time class="member-clock" data-member-clock><?= date('H : i : s') ?></time>
</header>
<div class="member-shell">
    <aside class="member-sidebar">
        <a class="member-sidebar__logo" href="<?= htmlspecialchars(site_url('inicio/'), ENT_QUOTES, 'UTF-8') ?>"><img src="<?= htmlspecialchars(site_url('assets/images/logoamuvieblanco.png'), ENT_QUOTES, 'UTF-8') ?>" alt="AMUVIE A.C."></a>
        <nav><?php foreach ($menu as [$icon, $label, $url]): ?><a href="<?= $url === '#' ? '#' : htmlspecialchars(site_url($url), ENT_QUOTES, 'UTF-8') ?>" class="<?= $label === 'Mi Perfil' ? 'is-active' : '' ?>"><i class="fas <?= $icon ?>"></i><span><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span></a><?php endforeach; ?></nav>
    </aside>
    <main class="profile-page">
        <form class="profile-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <h1>Mi Perfil</h1>
            <?php if ($profileError): ?><p class="profile-message profile-message--error" role="alert"><?= htmlspecialchars($profileError, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
            <?php if ($profileSuccess): ?><p class="profile-message profile-message--success" role="status"><?= htmlspecialchars($profileSuccess, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
            <div class="profile-photo-row">
                <span>Foto de perfil</span>
                <div class="profile-photo-editor" data-profile-photo-editor>
                    <div class="profile-photo-preview">
                        <img class="profile-photo<?= empty($profile['photo_path']) ? ' is-hidden' : '' ?>" data-profile-photo-preview src="<?= !empty($profile['photo_path']) ? htmlspecialchars(site_url($profile['photo_path']), ENT_QUOTES, 'UTF-8') : '' ?>" alt="Vista previa de la fotografía">
                        <span class="profile-photo-placeholder<?= !empty($profile['photo_path']) ? ' is-hidden' : '' ?>" data-profile-photo-placeholder><i class="fas fa-user"></i></span>
                    </div>
                    <label class="profile-photo-button" for="profile-photo-input"><i class="fas fa-camera"></i> Elegir fotografía</label>
                    <input id="profile-photo-input" class="profile-photo-input" type="file" name="photo" accept="image/jpeg,image/png,image/webp" data-profile-photo-input>
                    <?php if (!empty($profile['photo_path'])): ?><label class="profile-photo-remove"><input type="checkbox" name="remove_photo" value="1" data-remove-profile-photo> Eliminar foto actual</label><?php endif; ?>
                    <small>JPG, PNG o WebP; máximo 2 MB. Usa una imagen cuadrada de al menos 200×200 px.</small>
                </div>
            </div>

            <fieldset><legend>Nombre Completo</legend>
                <label><span>Usuario <b>*</b></span><div><input value="<?= $value('username') ?>" disabled><small>El nombre de usuario no se puede cambiar.</small></div></label>
                <label><span>Nombre(s)</span><input name="first_name" maxlength="100" value="<?= $value('first_name') ?>"></label>
                <label><span>Apellido(s)</span><input name="last_name" maxlength="100" value="<?= $value('last_name') ?>"></label>
                <label><span>Empresa <b>*</b></span><input name="company" maxlength="150" value="<?= $value('company') ?>" required></label>
                <label><span>Fecha de Ingreso a AMUVIE</span><input type="date" name="joined_at" value="<?= $value('joined_at') ?>"></label>
                <label><span>Mostrar nombre públicamente como</span><select name="public_name"><option value="<?= $value('username') ?>"><?= $value('username') ?></option><option value="<?= htmlspecialchars(trim(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')), ENT_QUOTES, 'UTF-8') ?>" <?= ($profile['public_name'] ?? '') !== ($profile['username'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars(trim(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')), ENT_QUOTES, 'UTF-8') ?></option></select></label>
            </fieldset>
            <fieldset><legend>Datos de contacto</legend>
                <label><span>Ciudad</span><input name="city" value="<?= $value('city') ?>"></label><label><span>Estado</span><input name="state" value="<?= $value('state') ?>"></label>
                <label><span>Teléfono</span><div><input name="phone" value="<?= $value('phone') ?>"><small>Formato requerido: (###) ###-####</small></div></label><label><span>Celular</span><div><input name="mobile" value="<?= $value('mobile') ?>"><small>Formato requerido: (###) ###-####</small></div></label>
                <label><span>Correo Electrónico <b>*</b></span><input type="email" name="email" value="<?= $value('email') ?>" required></label><label><span>Website</span><input type="url" name="website" value="<?= $value('website') ?>"></label>
            </fieldset>
            <fieldset><legend>Acerca de ti mismo</legend>
                <label><span>Fecha de Nacimiento</span><input type="date" name="birth_date" value="<?= $value('birth_date') ?>"></label>
                <label><span>Información Biográfica</span><div><textarea name="biography" rows="6"><?= $value('biography') ?></textarea><small>Comparta un poco de información biográfica para completar su perfil.</small></div></label>
                <label><span>Contraseña</span><div><input type="password" name="new_password" autocomplete="new-password"><small>Escribe una nueva contraseña únicamente si deseas cambiarla.</small></div></label>
            </fieldset>
            <fieldset><legend>Información de Facturación <small>Modifica tu información de facturación</small></legend>
                <label><span>Razón Social</span><input name="business_name" value="<?= $value('business_name') ?>"></label><label><span>RFC</span><input name="tax_id" value="<?= $value('tax_id') ?>"></label>
                <label><span>Dirección empresa</span><input name="business_address" value="<?= $value('business_address') ?>"></label><label><span>No. Ext</span><input name="exterior_number" value="<?= $value('exterior_number') ?>"></label>
                <label><span>Colonia</span><input name="neighborhood" value="<?= $value('neighborhood') ?>"></label><label><span>Municipio</span><input name="municipality" value="<?= $value('municipality') ?>"></label><label><span>C.P.</span><input name="postal_code" value="<?= $value('postal_code') ?>"></label>
                <label><span>Uso del CFDI 3.3</span><select name="cfdi_use"><option><?= $value('cfdi_use') ?></option><option>G01 - Adquisición de mercancías</option><option>G03 - Gastos en general</option></select></label>
                <label><span>Método de pago</span><select name="payment_method"><option><?= $value('payment_method') ?></option><option>Transferencia</option><option>Tarjeta</option><option>Efectivo</option></select></label>
                <label><span>Teléfono empresa (incluir lada)</span><input name="business_phone" value="<?= $value('business_phone') ?>"></label><label><span>Correo empresa</span><input type="email" name="business_email" value="<?= $value('business_email') ?>"></label>
            </fieldset>
            <button class="profile-submit" type="submit">Actualizar</button>
        </form>
        <footer class="member-footer">Copyright © <?= date('Y') ?> Asociación Mexicana de Unidades de Verificación, Inspección y Estandarización AC.</footer>
    </main>
</div>
