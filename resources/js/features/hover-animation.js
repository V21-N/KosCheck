/**
 * Hover Animation
 * Advanced hover effects for interactive elements
 */
export function initHoverAnimations() {
    // Hover lift effect
    document.querySelectorAll('[data-hover="lift"]').forEach(el => {
        el.addEventListener('mouseenter', () => {
            el.style.transform = 'translateY(-8px)';
            el.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1)';
        });
        el.addEventListener('mouseleave', () => {
            el.style.transform = '';
            el.style.boxShadow = '';
        });
    });

    // Hover scale effect
    document.querySelectorAll('[data-hover="scale"]').forEach(el => {
        el.addEventListener('mouseenter', () => {
            el.style.transform = 'scale(1.05)';
        });
        el.addEventListener('mouseleave', () => {
            el.style.transform = '';
        });
    });

    // Hover glow effect
    document.querySelectorAll('[data-hover="glow"]').forEach(el => {
        el.addEventListener('mouseenter', () => {
            el.style.boxShadow = '0 0 30px rgba(244, 124, 32, 0.4)';
        });
        el.addEventListener('mouseleave', () => {
            el.style.boxShadow = '';
        });
    });

    // Hover rotate effect
    document.querySelectorAll('[data-hover="rotate"]').forEach(el => {
        el.addEventListener('mouseenter', () => {
            el.style.transform = 'rotate(3deg) scale(1.05)';
        });
        el.addEventListener('mouseleave', () => {
            el.style.transform = '';
        });
    });

    // Card lift on hover with image zoom
    document.querySelectorAll('[data-card-hover]').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.querySelectorAll('img').forEach(img => {
                img.style.transform = 'scale(1.1)';
                img.style.transition = 'transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            });
        });
        card.addEventListener('mouseleave', function() {
            this.querySelectorAll('img').forEach(img => {
                img.style.transform = '';
            });
        });
    });

    // Apply smooth transitions
    document.querySelectorAll('[data-hover]').forEach(el => {
        if (!el.style.transition) {
            el.style.transition = 'all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
        }
    });
}

export function addHoverEffect(element, effect) {
    if (typeof element === 'string') {
        element = document.querySelector(element);
    }
    if (!element) return;
    element.setAttribute('data-hover', effect);
    element.style.transition = 'all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
    initHoverAnimations();
}

window.addHoverEffect = addHoverEffect;
