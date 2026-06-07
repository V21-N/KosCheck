/**
 * Lazy Load
 * Load images and backgrounds only when they enter the viewport
 */
const LAZY_CLASS = 'lazy-loading';
const LOADED_CLASS = 'lazy-loaded';

export function initLazyLoad(options = {}) {
    const defaultOptions = {
        threshold: 0.1,
        rootMargin: '50px',
        ...options
    };

    // If IntersectionObserver is not supported, load all images immediately
    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll('img[data-src]').forEach(img => {
            loadImage(img);
        });
        document.querySelectorAll('[data-bg-image]').forEach(el => {
            loadBackground(el);
        });
        return;
    }

    // Lazy load images
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                loadImage(img);
                imageObserver.unobserve(img);
            }
        });
    }, defaultOptions);

    document.querySelectorAll('img[data-src]').forEach((img) => {
        img.classList.add(LAZY_CLASS);
        imageObserver.observe(img);
    });

    // Lazy load background images
    const bgObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                loadBackground(el);
                bgObserver.unobserve(el);
            }
        });
    }, defaultOptions);

    document.querySelectorAll('[data-bg-image]').forEach((el) => {
        bgObserver.observe(el);
    });
}

function loadImage(img) {
    if (img.dataset.src) {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
    }
    if (img.dataset.srcset) {
        img.srcset = img.dataset.srcset;
        img.removeAttribute('data-srcset');
    }
    img.classList.remove(LAZY_CLASS);
    img.classList.add(LOADED_CLASS);
}

function loadBackground(el) {
    const bgImage = el.dataset.bgImage;
    if (bgImage) {
        el.style.backgroundImage = `url('${bgImage}')`;
        el.removeAttribute('data-bg-image');
    }
    el.classList.add('lazy-bg-loaded');
}

/** Reload lazy loaded images after dynamic content insertion */
export function reloadLazyLoad() {
    initLazyLoad();
}

window.reloadLazyLoad = reloadLazyLoad;
