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

        if (contactStatus) {
            contactStatus.textContent = 'Formulario validado. El envío se habilitará al conectar el servicio de correo.';
        }
    });
}

const standalonePasswordInput = document.querySelector('[data-password-input]');
const standalonePasswordToggle = document.querySelector('[data-password-toggle]');

if (standalonePasswordInput && standalonePasswordToggle) {
    standalonePasswordToggle.addEventListener('click', () => {
        const willShowPassword = standalonePasswordInput.type === 'password';
        standalonePasswordInput.type = willShowPassword ? 'text' : 'password';
        standalonePasswordToggle.setAttribute('aria-pressed', String(willShowPassword));
        standalonePasswordToggle.setAttribute(
            'aria-label',
            willShowPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
        );
        standalonePasswordToggle.querySelector('i')?.classList.toggle('fa-eye', !willShowPassword);
        standalonePasswordToggle.querySelector('i')?.classList.toggle('fa-eye-slash', willShowPassword);
    });
}

const accessPageForm = document.querySelector('[data-access-form]');

if (accessPageForm) {
    const passwordInput = accessPageForm.querySelector('[data-password-input]');
    const passwordToggle = accessPageForm.querySelector('[data-password-toggle]');

    passwordToggle?.addEventListener('click', () => {
        if (!passwordInput) return;
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

}

const memberClock = document.querySelector('[data-member-clock]');
if (memberClock) {
    const updateMemberClock = () => {
        memberClock.textContent = new Date().toLocaleTimeString('es-MX', { hour12: false }).replaceAll(':', ' : ');
    };
    updateMemberClock();
    window.setInterval(updateMemberClock, 1000);
}

document.querySelectorAll('[data-credential-qr]').forEach((qr) => {
    const value = qr.dataset.qrValue || '';
    let seed = Array.from(value).reduce((total, character) => ((total * 31) + character.charCodeAt(0)) >>> 0, 2166136261);
    const size = 25;
    const finder = (row, column, top, left) => row >= top && row < top + 7 && column >= left && column < left + 7
        && (row === top || row === top + 6 || column === left || column === left + 6 || (row >= top + 2 && row <= top + 4 && column >= left + 2 && column <= left + 4));
    for (let row = 0; row < size; row += 1) {
        for (let column = 0; column < size; column += 1) {
            seed = ((seed * 1664525) + 1013904223) >>> 0;
            const module = document.createElement('span');
            const inFinderArea = (row < 7 && column < 7) || (row < 7 && column >= size - 7) || (row >= size - 7 && column < 7);
            const finderOn = finder(row, column, 0, 0) || finder(row, column, 0, size - 7) || finder(row, column, size - 7, 0);
            if (finderOn || (!inFinderArea && seed % 3 !== 0)) module.className = 'is-dark';
            qr.appendChild(module);
        }
    }
});

document.querySelector('[data-print-credential]')?.addEventListener('click', () => window.print());

const librarySearch = document.querySelector('[data-library-search]');
if (librarySearch) {
    const libraryDocuments = Array.from(document.querySelectorAll('[data-library-document]'));
    const libraryCount = document.querySelector('[data-library-count]');
    const libraryEmpty = document.querySelector('[data-library-empty]');
    const normalizeLibraryText = (text) => text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('es-MX');
    librarySearch.addEventListener('input', () => {
        const query = normalizeLibraryText(librarySearch.value.trim());
        let visible = 0;
        libraryDocuments.forEach((documentCard) => {
            const matches = normalizeLibraryText(documentCard.dataset.search).includes(query);
            documentCard.hidden = !matches;
            if (matches) visible += 1;
        });
        libraryCount.textContent = `${visible} ${visible === 1 ? 'documento' : 'documentos'}`;
        libraryEmpty.hidden = visible !== 0;
    });
}

const formatRequest = document.querySelector('[data-format-request]');
if (formatRequest) {
    const requestTotal = formatRequest.querySelector('[data-request-total]');
    const requestFiles = formatRequest.querySelector('[data-request-files]');
    const uploadLabel = formatRequest.querySelector('[data-upload-label]');
    formatRequest.querySelectorAll('[data-delivery-price]').forEach((option) => option.addEventListener('change', () => {
        requestTotal.textContent = `$${Number(option.dataset.deliveryPrice).toFixed(2)}`;
    }));
    requestFiles.addEventListener('change', () => {
        uploadLabel.textContent = requestFiles.files.length === 1 ? requestFiles.files[0].name : `${requestFiles.files.length} archivos seleccionados`;
    });
}

const tariffCalculator = document.querySelector('[data-tariff-calculator]');
if (tariffCalculator) {
    const tariffServices = Array.from(tariffCalculator.querySelectorAll('[name="tariff_service"]'));
    const tariffRange = tariffCalculator.querySelector('[data-tariff-range]');
    const tariffDownload = tariffCalculator.querySelector('[data-download-tariff]');
    const tariffSummary = tariffCalculator.querySelector('[data-tariff-summary]');
    const updateTariffSelection = () => {
        const selectedService = tariffServices.find((option) => option.checked)?.value || '';
        const isComplete = selectedService !== '' && tariffRange.value !== '';
        tariffDownload.disabled = !isComplete;
        tariffSummary.hidden = !isComplete;
        if (isComplete) {
            tariffSummary.querySelector('[data-summary-service]').textContent = selectedService;
            tariffSummary.querySelector('[data-summary-range]').textContent = tariffRange.value;
        }
    };
    tariffServices.forEach((option) => option.addEventListener('change', updateTariffSelection));
    tariffRange.addEventListener('change', updateTariffSelection);
    tariffDownload.addEventListener('click', () => window.print());
}
