/**
 * Mobile Menu
 * Mobile navigation menu toggle with slide-in effect
 */
export function initMobileMenu() {
    const menuToggles = document.querySelectorAll('[data-mobile-menu-toggle]');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuOverlay = document.getElementById('menu-overlay');

    if (!mobileMenu && menuToggles.length === 0) return;

    function openMenu() {
        mobileMenu?.classList.add('mobile-menu-open');
        menuOverlay?.classList.add('overlay-visible');
        document.body.classList.add('overflow-hidden');
        document.body.classList.add('menu-open');
    }

    function closeMenu() {
        mobileMenu?.classList.remove('mobile-menu-open');
        menuOverlay?.classList.remove('overlay-visible');
        document.body.classList.remove('overflow-hidden');
        document.body.classList.remove('menu-open');
    }

    // Toggle menu on button click
    menuToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            if (mobileMenu?.classList.contains('mobile-menu-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });
    });

    // Close menu on overlay click
    menuOverlay?.addEventListener('click', closeMenu);

    // Close menu when clicking menu items (links)
    mobileMenu?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            const href = link.getAttribute('href');
            if (href && href !== '#') {
                closeMenu();
            }
        });
    });

    // Close menu on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenu?.classList.contains('mobile-menu-open')) {
            closeMenu();
        }
    });
}

export function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuOverlay = document.getElementById('menu-overlay');
    if (!mobileMenu) return;
    const isOpen = mobileMenu.classList.toggle('mobile-menu-open');
    if (menuOverlay) {
        menuOverlay.classList.toggle('overlay-visible', isOpen);
    }
    document.body.classList.toggle('overflow-hidden', isOpen);
    document.body.classList.toggle('menu-open', isOpen);
}

export function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const menuOverlay = document.getElementById('menu-overlay');
    if (mobileMenu) {
        mobileMenu.classList.remove('mobile-menu-open');
        menuOverlay?.classList.remove('overlay-visible');
        document.body.classList.remove('overflow-hidden');
        document.body.classList.remove('menu-open');
    }
}

window.initMobileMenu = initMobileMenu;
window.toggleMobileMenu = toggleMobileMenu;
window.closeMobileMenu = closeMobileMenu;

