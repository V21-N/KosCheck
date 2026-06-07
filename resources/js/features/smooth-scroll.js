/**
 * Smooth Scroll
 * Smooth scrolling for anchor links and navigation
 */
export function initSmoothScroll() {
    // Handle anchor link clicks
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // Skip if href is just "#"
            if (href === '#' || !href) return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Smooth scroll for scrollIntoView calls
    window.addEventListener('wheel', () => {
        // Stop smooth scroll on user wheel interaction
        document.documentElement.style.scrollBehavior = 'auto';
        setTimeout(() => {
            document.documentElement.style.scrollBehavior = 'smooth';
        }, 50);
    }, { passive: true });
}
