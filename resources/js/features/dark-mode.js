/**
 * Dark Mode
 * Toggle and persist dark/light theme preference
 */
const STORAGE_KEY = 'koscheck-darkmode';

export function initDarkMode() {
    const htmlElement = document.documentElement;
    const darkModeToggles = document.querySelectorAll('[data-darkmode-toggle]');

    // Check saved preference or system preference
    const savedMode = localStorage.getItem(STORAGE_KEY);
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDarkMode = savedMode ? savedMode === 'true' : prefersDark;

    if (isDarkMode) {
        htmlElement.classList.add('dark');
    } else {
        htmlElement.classList.remove('dark');
    }

    // Bind toggle buttons
    darkModeToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            toggleDarkMode();
        });
    });

    // Watch for system preference changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem(STORAGE_KEY)) {
            if (e.matches) {
                htmlElement.classList.add('dark');
            } else {
                htmlElement.classList.remove('dark');
            }
        }
    });
}

export function toggleDarkMode() {
    const htmlElement = document.documentElement;
    const isDark = htmlElement.classList.toggle('dark');
    localStorage.setItem(STORAGE_KEY, isDark ? 'true' : 'false');

    // Dispatch custom event for other components
    document.dispatchEvent(new CustomEvent('darkmode-change', { detail: { isDark } }));

    return isDark;
}

export function isDarkModeEnabled() {
    return document.documentElement.classList.contains('dark');
}

window.toggleDarkMode = toggleDarkMode;
window.isDarkModeEnabled = isDarkModeEnabled;
