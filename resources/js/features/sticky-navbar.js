/**
 * Sticky Navbar
 * Navbar becomes sticky with enhanced shadow and reduced padding on scroll
 */
export function initStickyNavbar() {
    const navbar = document.querySelector('nav.navbar');
    if (!navbar) return;

    const scrollThreshold = 50;
    let lastScrollTop = 0;
    let ticking = false;

    function updateNavbar() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > scrollThreshold) {
            navbar.classList.add('sticky-navbar');

            // Add hide-on-scroll-down behavior for mobile
            if (window.innerWidth < 768) {
                if (scrollTop > lastScrollTop && scrollTop > 200) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
            }
        } else {
            navbar.classList.remove('sticky-navbar');
            navbar.style.transform = '';
        }

        lastScrollTop = scrollTop;
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(updateNavbar);
            ticking = true;
        }
    }, { passive: true });

    // Initial check
    updateNavbar();
}
