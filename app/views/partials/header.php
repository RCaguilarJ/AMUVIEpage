<header class="amuvie-site-header" id="inicio">
    <div class="amuvie-topbar" aria-label="Información de contacto">
        <div class="amuvie-topbar__column">
            <i class="fas fa-envelope" aria-hidden="true"></i>
            <a href="mailto:admin@amuvie.mx">admin@amuvie.mx</a>
        </div>
        <div class="amuvie-topbar__column">
            <i class="fas fa-clock" aria-hidden="true"></i>
            <span>Horario de Atención: 9:00 am - 4:00 pm Hora del Centro de México</span>
        </div>
    </div>

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

        <a class="amuvie-login-button" href="<?= htmlspecialchars(site_url('portal-amuvie/'), ENT_QUOTES, 'UTF-8') ?>">
            <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
            <span>Acceder</span>
        </a>
    </div>
</header>

<aside class="partner-rail" aria-label="Patrocinadores">
    <a href="#" aria-label="ANCE">
        <img src="<?= htmlspecialchars(site_url('assets/images/logo-ance.png'), ENT_QUOTES, 'UTF-8') ?>" alt="ANCE">
    </a>
    <a href="#" aria-label="ema">
        <img src="<?= htmlspecialchars(site_url('assets/images/logo-ema.png'), ENT_QUOTES, 'UTF-8') ?>" alt="ema">
    </a>
</aside>
