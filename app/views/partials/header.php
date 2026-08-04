<?php require_once dirname(__DIR__, 2) . '/auth.php'; $headerUser = currentUser(); ?>
<header class="amuvie-site-header" id="inicio">
    <div class="amuvie-topbar<?= !empty($isMemberView) ? ' amuvie-topbar--private' : '' ?>" aria-label="<?= !empty($isMemberView) ? 'Sesión del asociado' : 'Información de contacto' ?>">
        <?php if (!empty($isMemberView) && $headerUser): ?>
        <div class="amuvie-private-welcome"><i class="fas fa-user-tie" aria-hidden="true"></i> Bienvenido de nuevo, <?= htmlspecialchars($headerUser['full_name'] ?: $headerUser['username'], ENT_QUOTES, 'UTF-8') ?></div>
        <form method="post" class="amuvie-private-logout">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="action" value="logout">
            <button type="submit"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Cerrar sesión</button>
        </form>
        <time class="amuvie-private-clock" data-member-clock><?= date('H : i : s') ?></time>
        <?php else: ?>
        <div class="amuvie-topbar__column">
            <i class="fas fa-envelope" aria-hidden="true"></i>
            <a href="mailto:admin@amuvie.mx">admin@amuvie.mx</a>
        </div>
        <div class="amuvie-topbar__column">
            <i class="fas fa-clock" aria-hidden="true"></i>
            <span>Horario de Atención: 9:00 am - 4:00 pm Hora del Centro de México</span>
        </div>
        <?php endif; ?>
    </div>

    <?php if (empty($isMemberView)): ?>
    <div class="amuvie-main-header">
        <a class="amuvie-brand" href="<?= htmlspecialchars(site_url('inicio/'), ENT_QUOTES, 'UTF-8') ?>" aria-label="AMUVIE A.C. — Inicio">
            <img class="amuvie-brand__logo" src="<?= htmlspecialchars(site_url('assets/images/logo-amuvie.png'), ENT_QUOTES, 'UTF-8') ?>" width="250" height="250" alt="AMUVIE A.C.">
        </a>

        <nav class="amuvie-primary-nav" aria-label="Navegación principal">
            <ul class="amuvie-primary-nav__list">
                <li class="amuvie-primary-nav__item--submenu">
                    <a href="#" aria-haspopup="true">AMUVIE <i class="fas fa-chevron-down" aria-hidden="true"></i></a>
                    <ul class="amuvie-submenu">
                        <li><a href="<?= htmlspecialchars(site_url('quienes-somos/'), ENT_QUOTES, 'UTF-8') ?>">¿Quiénes somos?</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('consejo-directivo/'), ENT_QUOTES, 'UTF-8') ?>">Consejo Directivo</a></li>
                    </ul>
                </li>
                <li class="amuvie-primary-nav__item--submenu">
                    <a href="#" aria-haspopup="true">Nuestros servicios <i class="fas fa-chevron-down" aria-hidden="true"></i></a>
                    <ul class="amuvie-submenu">
                        <li><a href="<?= htmlspecialchars(site_url('formatos-de-portada/'), ENT_QUOTES, 'UTF-8') ?>">Formatos de Portada</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('capacitacion/'), ENT_QUOTES, 'UTF-8') ?>">Capacitación</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('libro-calidad-energia-electrica/'), ENT_QUOTES, 'UTF-8') ?>">Libro Calidad de Energía Eléctrica</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('bolsa-de-trabajo/'), ENT_QUOTES, 'UTF-8') ?>">Bolsa de trabajo</a></li>
                    </ul>
                </li>
                <li class="amuvie-primary-nav__item--submenu">
                    <a
                        class="amuvie-submenu-trigger"
                        href="#"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-controls="submenu-directorios"
                    >
                        Directorios <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </a>
                    <ul class="amuvie-submenu amuvie-submenu--directories" id="submenu-directorios">
                        <li><a href="<?= htmlspecialchars(site_url('consejo-directivo/'), ENT_QUOTES, 'UTF-8') ?>">Consejo Directivo</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('asociados/'), ENT_QUOTES, 'UTF-8') ?>">Asociados</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('institucional/'), ENT_QUOTES, 'UTF-8') ?>">Institucional</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('convenios-comerciales-para-afiliados/'), ENT_QUOTES, 'UTF-8') ?>">Convenios comerciales para afiliados</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('proveedores-asociados/'), ENT_QUOTES, 'UTF-8') ?>">Proveedores – Asociados</a></li>
                    </ul>
                </li>
                <li class="amuvie-primary-nav__item--submenu">
                    <a
                        class="amuvie-submenu-trigger"
                        href="<?= htmlspecialchars(site_url('comunicacion/'), ENT_QUOTES, 'UTF-8') ?>"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-controls="submenu-comunicacion"
                    >
                        Comunicación <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </a>
                    <ul class="amuvie-submenu" id="submenu-comunicacion">
                        <li><a href="<?= htmlspecialchars(site_url('comunicacion/'), ENT_QUOTES, 'UTF-8') ?>">Últimas notas</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('comunicacion/eventos/'), ENT_QUOTES, 'UTF-8') ?>">Eventos</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('comunicacion/memoria-de-eventos/'), ENT_QUOTES, 'UTF-8') ?>">Memoria de eventos</a></li>
                        <li><a href="<?= htmlspecialchars(site_url('comunicacion/boletines/'), ENT_QUOTES, 'UTF-8') ?>">Boletines</a></li>
                    </ul>
                </li>
                <li><a href="<?= htmlspecialchars(site_url('informacion/'), ENT_QUOTES, 'UTF-8') ?>">Información</a></li>
                <li><a href="<?= htmlspecialchars(site_url('instituciones/'), ENT_QUOTES, 'UTF-8') ?>">Instituciones</a></li>
                <li><a href="<?= htmlspecialchars(site_url('afiliate/'), ENT_QUOTES, 'UTF-8') ?>">Afíliate</a></li>
                <li><a href="<?= htmlspecialchars(site_url('contactanos/'), ENT_QUOTES, 'UTF-8') ?>">Contáctanos</a></li>
            </ul>
        </nav>

        <button class="amuvie-menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>

        <div class="amuvie-header-actions">
            <a class="amuvie-login-button" href="<?= htmlspecialchars(site_url($headerUser ? 'mi-perfil/' : 'portal-amuvie/'), ENT_QUOTES, 'UTF-8') ?>">
                <i class="fas <?= $headerUser ? 'fa-user' : 'fa-sign-in-alt' ?>" aria-hidden="true"></i>
                <span><?= $headerUser ? 'Mi perfil' : 'Acceder' ?></span>
            </a>
            <?php if ($headerUser): ?>
                <form method="post" class="amuvie-logout-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit"><i class="fas fa-sign-out-alt" aria-hidden="true"></i><span>Cerrar sesión</span></button>
                </form>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</header>

<?php if (empty($isMemberView)): ?>
<aside class="partner-rail" aria-label="Patrocinadores">
    <a href="https://www.anceestandares.org.mx/" target="_blank" rel="noopener noreferrer" aria-label="Visitar ANCE Estándares">
        <img src="<?= htmlspecialchars(site_url('assets/images/logo-ance.png'), ENT_QUOTES, 'UTF-8') ?>" alt="ANCE">
    </a>
    <a href="https://www.ema.org.mx/portal_v3/" target="_blank" rel="noopener noreferrer" aria-label="Visitar Entidad Mexicana de Acreditación">
        <img src="<?= htmlspecialchars(site_url('assets/images/logo-ema.png'), ENT_QUOTES, 'UTF-8') ?>" alt="ema">
    </a>
</aside>
<?php endif; ?>
