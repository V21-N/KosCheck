// Main Features Initialization
// Import all feature modules
import { initSmoothScroll } from './features/smooth-scroll';
import { initStickyNavbar } from './features/sticky-navbar';
import { initDarkMode } from './features/dark-mode';
import { initSkeletonLoading } from './features/skeleton-loading';
import { initLazyLoad } from './features/lazy-load';
import { showToast, removeToast, clearAllToasts } from './features/toast-notification';
import { initMobileMenu } from './features/mobile-menu';
import { initFormValidation } from './features/form-validation';
import { initBackToTop } from './features/back-to-top';
import { initHoverAnimations } from './features/hover-animation';
import { initMicroInteractions } from './features/micro-interactions';
import { initPageTransition } from './features/page-transition';
import { initScrollReveal } from './features/scroll-reveal';
import { initScrollAnimation } from './scroll-animation';

/**
 * Initialize all features
 * Call this function on DOMContentLoaded
 */
export function initializeAllFeatures() {
    // Disabled for mobile performance - scroll animations cause jank on low-end devices
    // try {
    //     initScrollAnimation();
    // } catch (e) {
    //     console.warn('⚠ Scroll Animation error:', e);
    // }

    try {
        initSmoothScroll();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initStickyNavbar();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initDarkMode();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initSkeletonLoading();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initLazyLoad();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initMobileMenu();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initFormValidation();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initBackToTop();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initHoverAnimations();
    } catch (e) {
        // Silent fail for non-critical features
    }

    try {
        initMicroInteractions();
    } catch (e) {
        // Silent fail for non-critical features
    }

    // Disabled for mobile performance
    // try {
    //     initPageTransition();
    // } catch (e) {
    //     console.warn('⚠ Page Transition error:', e);
    // }

    // try {
    //     initScrollReveal();
    // } catch (e) {
    //     console.warn('⚠ Scroll Reveal error:', e);
    // }
}

// Export all functions globally
export {
    initScrollAnimation,
    initSmoothScroll,
    initStickyNavbar,
    initDarkMode,
    initSkeletonLoading,
    initLazyLoad,
    initMobileMenu,
    initFormValidation,
    initBackToTop,
    initHoverAnimations,
    initMicroInteractions,
    initPageTransition,
    initScrollReveal
};
