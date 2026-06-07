/**
 * Skeleton Loading
 * Show skeleton placeholders while content is loading
 */
export function initSkeletonLoading() {
    // Auto-detect skeleton wrappers
    const skeletonWrappers = document.querySelectorAll('.skeleton-wrapper');
    skeletonWrappers.forEach(wrapper => {
        const loaders = wrapper.querySelectorAll('.skeleton-loader');
        loaders.forEach(loader => {
            loader.classList.add('skeleton-pulse');
        });
    });
}

/**
 * Show skeleton loading on a parent element
 * @param {HTMLElement} parentElement
 * @param {number} count
 * @returns {HTMLElement} The skeleton wrapper
 */
export function showSkeleton(parentElement, count = 1, template = 'card') {
    if (!parentElement) return null;

    const wrapper = document.createElement('div');
    wrapper.className = 'skeleton-wrapper space-y-4';

    for (let i = 0; i < count; i++) {
        const skeleton = document.createElement('div');
        skeleton.className = 'skeleton-loader h-24 bg-gray-200 rounded-lg skeleton-pulse';
        wrapper.appendChild(skeleton);
    }

    parentElement.appendChild(wrapper);
    return wrapper;
}

/**
 * Remove skeleton loader with fade-out
 * @param {HTMLElement} skeletonElement
 */
export function removeSkeleton(skeletonElement) {
    if (skeletonElement) {
        skeletonElement.style.opacity = '0';
        skeletonElement.style.transform = 'translateY(-10px)';
        skeletonElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        setTimeout(() => skeletonElement.remove(), 300);
    }
}

window.showSkeleton = showSkeleton;
window.removeSkeleton = removeSkeleton;
