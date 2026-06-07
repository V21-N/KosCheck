/**
 * Page Transition
 * Smooth page transitions with loading indicator
 */
let isTransitioning = false;

export function initPageTransition() {
    if (document.getElementById('page-transition-overlay')) return;

    const overlay = document.createElement('div');
    overlay.id = 'page-transition-overlay';
    overlay.style.cssText = 'position:fixed;inset:0;background:#fff;z-index:9998;pointer-events:none;opacity:0;transition:opacity 0.3s ease;';
    document.body.appendChild(overlay);

    const indicator = document.createElement('div');
    indicator.id = 'page-loading-indicator';
    indicator.style.cssText = 'position:fixed;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#F47C20,#D95A00);z-index:9999;transform-origin:left center;transform:scaleX(0);transition:transform 0.3s ease;';
    document.body.appendChild(indicator);

    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        if (!href ||
            href.startsWith('#') ||
            href.startsWith('javascript:') ||
            href.startsWith('tel:') ||
            href.startsWith('mailto:') ||
            link.target === '_blank' ||
            link.hasAttribute('data-no-transition') ||
            link.hasAttribute('download') ||
            link.hasAttribute('x-data') ||
            link.closest('[x-data]')) {
            return;
        }

        if (link.hostname !== window.location.hostname) return;

        e.preventDefault();
        transitionToPage(href);
    });
}

export function transitionToPage(url) {
    if (isTransitioning) return;
    isTransitioning = true;

    const overlay = document.getElementById('page-transition-overlay');
    const indicator = document.getElementById('page-loading-indicator');

    if (indicator) indicator.style.transform = 'scaleX(1)';

    setTimeout(() => {
        if (overlay) {
            overlay.style.opacity = '1';
            overlay.style.pointerEvents = 'auto';
        }
    }, 150);

    setTimeout(() => {
        window.location.href = url;
    }, 400);
}

export function completePageTransition() {
    const overlay = document.getElementById('page-transition-overlay');
    const indicator = document.getElementById('page-loading-indicator');

    if (indicator) indicator.style.transform = 'scaleX(0)';
    if (overlay) {
        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';
    }
    isTransitioning = false;
}

// Initial cleanup
document.addEventListener('DOMContentLoaded', completePageTransition);
window.addEventListener('pageshow', completePageTransition);

window.transitionToPage = transitionToPage;
window.completePageTransition = completePageTransition;
