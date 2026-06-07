/**
 * Scroll Reveal
 * Reveal elements with animations as they enter the viewport
 */
const defaultOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

export function initScrollReveal(options = {}) {
    const revealElements = document.querySelectorAll('[data-reveal]');

    if (!('IntersectionObserver' in window)) {
        revealElements.forEach(el => el.classList.add('revealed'));
        return;
    }

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = el.dataset.revealDelay || '0';
                const duration = el.dataset.revealDuration || '0.6s';

                el.style.animationDelay = `${delay}s`;
                el.style.animationDuration = duration;
                el.classList.add('revealed');

                revealObserver.unobserve(el);
            }
        });
    }, { ...defaultOptions, ...options });

    revealElements.forEach(el => {
        el.classList.add('scroll-reveal-hidden');
        revealObserver.observe(el);
    });
}

export function addReveal(element, animation = 'fade-in-up') {
    if (typeof element === 'string') {
        element = document.querySelector(element);
    }
    if (!element) return;

    element.setAttribute('data-reveal', animation);
    element.classList.add('scroll-reveal-hidden');
    initScrollReveal();
}

window.addReveal = addReveal;
