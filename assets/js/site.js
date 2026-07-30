const menuToggle = document.querySelector('.amuvie-menu-toggle');
const primaryMenu = document.querySelector('.amuvie-primary-nav');
const submenuTriggers = document.querySelectorAll('.amuvie-submenu-trigger');

submenuTriggers.forEach((trigger) => {
    trigger.addEventListener('click', (event) => {
        const href = trigger.getAttribute('href');

        if (window.innerWidth > 1180 && href && href !== '#') {
            return;
        }

        event.preventDefault();
        const menuItem = trigger.closest('.amuvie-primary-nav__item--submenu');
        const willOpen = !menuItem.classList.contains('is-open');

        document.querySelectorAll('.amuvie-primary-nav__item--submenu.is-open').forEach((item) => {
            item.classList.remove('is-open');
            item.querySelector('[aria-expanded]')?.setAttribute('aria-expanded', 'false');
        });

        menuItem.classList.toggle('is-open', willOpen);
        trigger.setAttribute('aria-expanded', String(willOpen));
        if (!willOpen) trigger.blur();
    });
});

document.querySelectorAll('.blog-card img').forEach((image) => {
    image.addEventListener('error', () => {
        image.hidden = true;
    });
});

document.addEventListener('click', (event) => {
    if (!event.target.closest('.amuvie-primary-nav__item--submenu')) {
        document.querySelectorAll('.amuvie-primary-nav__item--submenu.is-open').forEach((item) => {
            item.classList.remove('is-open');
            item.querySelector('[aria-expanded]')?.setAttribute('aria-expanded', 'false');
        });
    }
});

if (menuToggle && primaryMenu) {
    const closeMenu = () => {
        document.body.classList.remove('menu-open');
        document.querySelectorAll('.amuvie-primary-nav__item--submenu.is-open').forEach((item) => {
            item.classList.remove('is-open');
            item.querySelector('[aria-expanded]')?.setAttribute('aria-expanded', 'false');
        });
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-label', 'Abrir menú');
        menuToggle.querySelector('i')?.classList.add('fa-bars');
        menuToggle.querySelector('i')?.classList.remove('fa-times');
    };

    menuToggle.addEventListener('click', () => {
        const isOpen = document.body.classList.toggle('menu-open');
        menuToggle.setAttribute('aria-expanded', String(isOpen));
        menuToggle.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
        menuToggle.querySelector('i')?.classList.toggle('fa-bars', !isOpen);
        menuToggle.querySelector('i')?.classList.toggle('fa-times', isOpen);
    });

    primaryMenu.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (link && !link.hasAttribute('aria-haspopup') && window.innerWidth <= 1180) {
            closeMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1180) closeMenu();
    });
}

document.querySelectorAll('[role="tablist"]').forEach((tabList) => {
    const tabs = Array.from(tabList.querySelectorAll('[role="tab"]'));

    function activateTab(selectedTab) {
        tabs.forEach((tab) => {
            const isSelected = tab === selectedTab;
            const panel = document.getElementById(tab.getAttribute('aria-controls'));

            tab.setAttribute('aria-selected', String(isSelected));
            tab.tabIndex = isSelected ? 0 : -1;
            panel.hidden = !isSelected;
        });
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => activateTab(tab));
        tab.addEventListener('keydown', (event) => {
            if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) {
                return;
            }

            event.preventDefault();
            let nextIndex = index;

            if (event.key === 'ArrowRight') nextIndex = (index + 1) % tabs.length;
            if (event.key === 'ArrowLeft') nextIndex = (index - 1 + tabs.length) % tabs.length;
            if (event.key === 'Home') nextIndex = 0;
            if (event.key === 'End') nextIndex = tabs.length - 1;

            activateTab(tabs[nextIndex]);
            tabs[nextIndex].focus();
        });
    });
});

const associatesSearch = document.querySelector('[data-associates-search]');

if (associatesSearch) {
    const associateRows = Array.from(document.querySelectorAll('[data-associate-row]'));
    const associatesEmpty = document.querySelector('[data-associates-empty]');
    const associatesResults = document.querySelector('[data-associates-results]');
    const normalizeSearchText = (value) => value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLocaleLowerCase('es-MX')
        .trim();

    associateRows.forEach((row) => {
        row.dataset.searchText = normalizeSearchText(row.textContent);
    });

    associatesSearch.addEventListener('input', () => {
        const query = normalizeSearchText(associatesSearch.value);
        let visibleRows = 0;

        associateRows.forEach((row) => {
            const matches = query === '' || row.dataset.searchText.includes(query);
            row.hidden = !matches;
            if (matches) visibleRows += 1;
        });

        associatesEmpty.hidden = visibleRows !== 0;
        associatesResults.textContent = visibleRows === 1
            ? '1 asociado'
            : `${visibleRows} asociados`;
    });
}

const contactPageForm = document.querySelector('[data-contact-form]');

if (contactPageForm) {
    const contactStatus = contactPageForm.querySelector('[data-contact-status]');

    contactPageForm.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!contactPageForm.checkValidity()) {
            contactPageForm.reportValidity();
            return;
        }

        contactStatus.textContent = 'Formulario validado. El envío se habilitará al conectar el servicio de correo.';
    });
}

const accessPageForm = document.querySelector('[data-access-form]');

if (accessPageForm) {
    const passwordInput = accessPageForm.querySelector('[data-password-input]');
    const passwordToggle = accessPageForm.querySelector('[data-password-toggle]');
    const accessStatus = accessPageForm.querySelector('[data-access-status]');

    passwordToggle.addEventListener('click', () => {
        const willShowPassword = passwordInput.type === 'password';
        passwordInput.type = willShowPassword ? 'text' : 'password';
        passwordToggle.setAttribute('aria-pressed', String(willShowPassword));
        passwordToggle.setAttribute(
            'aria-label',
            willShowPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );
        passwordToggle.querySelector('i')?.classList.toggle('fa-eye', !willShowPassword);
        passwordToggle.querySelector('i')?.classList.toggle('fa-eye-slash', willShowPassword);
    });

    accessPageForm.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!accessPageForm.checkValidity()) {
            accessPageForm.reportValidity();
            return;
        }

        accessStatus.textContent = 'Formulario validado. La autenticación se conectará con el backend del portal.';
    });
}
