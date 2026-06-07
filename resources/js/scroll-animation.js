/**
 * Scroll Animation
 * Elements animate in as they enter the viewport
 */
export function initScrollAnimation() {
    // Auto-add scroll-animate class to common elements if not already set
    const autoAnimateSelectors = [
        '.card',
        'section > div > *',
        '[class*="grid"] > *',
        'article',
        '.feature-item',
        '.team-member',
        '.service-box',
        '.product-card',
        '.review-item',
        '.info-card',
        '.stat-item',
    ];

    autoAnimateSelectors.forEach(selector => {
        try {
            document.querySelectorAll(selector).forEach(element => {
                if (!element.classList.contains('scroll-animate') &&
                    !element.classList.contains('scroll-animate-in') &&
                    !element.closest('.scroll-animate-container')) {
                    element.classList.add('scroll-animate');
                }
            });
        } catch (e) {
            console.debug('Selector failed:', selector);
        }
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const siblings = Array.from(entry.target.parentElement?.children || []);
                const index = siblings.indexOf(entry.target);

                entry.target.style.animationDelay = `${index * 0.1}s`;
                entry.target.classList.add('scroll-animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all elements with scroll-animate class
    document.querySelectorAll('.scroll-animate').forEach((el) => {
        observer.observe(el);
    });

    // Also observe containers
    document.querySelectorAll('.scroll-animate-container').forEach((container) => {
        const children = container.querySelectorAll(':scope > *');
        children.forEach((child, index) => {
            if (!child.classList.contains('scroll-animate')) {
                child.classList.add('scroll-animate');
                child.style.animationDelay = `${index * 0.1}s`;
                observer.observe(child);
            }
        });
    });
}


