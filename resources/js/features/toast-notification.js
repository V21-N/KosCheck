/**
 * Toast Notification
 * Floating toast messages with auto-dismiss
 */
let toastContainer = null;

function getToastContainer() {
    if (toastContainer) return toastContainer;

    toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.className = 'toast-container';
    document.body.appendChild(toastContainer);

    return toastContainer;
}

/**
 * Show a toast notification
 * @param {string} message - Toast message
 * @param {string} type - success, error, warning, info
 * @param {number} duration - Duration in ms, 0 for no auto-dismiss
 * @returns {string} toast ID
 */
export function showToast(message, type = 'info', duration = 4000) {
    const container = getToastContainer();
    const toastId = `toast-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;

    const icons = {
        'success': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        'error': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
        'warning': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'info': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
    };

    const toastEl = document.createElement('div');
    toastEl.id = toastId;
    toastEl.className = `toast-notification toast-${type}`;
    toastEl.innerHTML = `
        <span class="toast-icon">${icons[type] || icons.info}</span>
        <span class="toast-message">${message}</span>
        <button class="toast-close" aria-label="Tutup">&times;</button>
    `;

    // Close button
    toastEl.querySelector('.toast-close').addEventListener('click', () => {
        removeToast(toastId);
    });

    container.appendChild(toastEl);

    if (duration > 0) {
        setTimeout(() => {
            removeToast(toastId);
        }, duration);
    }

    return toastId;
}

export function removeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.classList.add('toast-exiting');
        setTimeout(() => toast.remove(), 300);
    }
}

export function clearAllToasts() {
    if (toastContainer) {
        toastContainer.querySelectorAll('.toast-notification').forEach(t => {
            t.classList.add('toast-exiting');
            setTimeout(() => t.remove(), 300);
        });
    }
}

window.showToast = showToast;
window.removeToast = removeToast;
window.clearAllToasts = clearAllToasts;
