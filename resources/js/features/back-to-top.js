/**
 * Back to Top
 * Floating button to scroll back to top of the page
 */
export function initBackToTop() {
    let backToTopBtn = document.getElementById('back-to-top-btn');

    if (!backToTopBtn) {
        backToTopBtn = document.createElement('button');
        backToTopBtn.id = 'back-to-top-btn';
        backToTopBtn.setAttribute('aria-label', 'Kembali ke atas');
        backToTopBtn.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>';
        document.body.appendChild(backToTopBtn);
    }

    let ticking = false;

    function updateButton() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > 300) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(updateButton);
            ticking = true;
        }
    }, { passive: true });

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Initial check
    updateButton();
}

export function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

window.scrollToTop = scrollToTop;
