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
    console.log('🚀 Initializing all features...');
    
    try {
        initScrollAnimation();
        console.log('✓ Scroll Animation initialized');
    } catch (e) {
        console.warn('⚠ Scroll Animation error:', e);
    }
    
    try {
        initSmoothScroll();
        console.log('✓ Smooth Scroll initialized');
    } catch (e) {
        console.warn('⚠ Smooth Scroll error:', e);
    }
    
    try {
        initStickyNavbar();
        console.log('✓ Sticky Navbar initialized');
    } catch (e) {
        console.warn('⚠ Sticky Navbar error:', e);
    }
    
    try {
        initDarkMode();
        console.log('✓ Dark Mode initialized');
    } catch (e) {
        console.warn('⚠ Dark Mode error:', e);
    }
    
    try {
        initSkeletonLoading();
        console.log('✓ Skeleton Loading initialized');
    } catch (e) {
        console.warn('⚠ Skeleton Loading error:', e);
    }
    
    try {
        initLazyLoad();
        console.log('✓ Lazy Load initialized');
    } catch (e) {
        console.warn('⚠ Lazy Load error:', e);
    }
    
    try {
        initMobileMenu();
        console.log('✓ Mobile Menu initialized');
    } catch (e) {
        console.warn('⚠ Mobile Menu error:', e);
    }
    
    try {
        initFormValidation();
        console.log('✓ Form Validation initialized');
    } catch (e) {
        console.warn('⚠ Form Validation error:', e);
    }
    
    try {
        initBackToTop();
        console.log('✓ Back to Top initialized');
    } catch (e) {
        console.warn('⚠ Back to Top error:', e);
    }
    
    try {
        initHoverAnimations();
        console.log('✓ Hover Animations initialized');
    } catch (e) {
        console.warn('⚠ Hover Animations error:', e);
    }
    
    try {
        initMicroInteractions();
        console.log('✓ Micro Interactions initialized');
    } catch (e) {
        console.warn('⚠ Micro Interactions error:', e);
    }
    
    try {
        initPageTransition();
        console.log('✓ Page Transition initialized');
    } catch (e) {
        console.warn('⚠ Page Transition error:', e);
    }
    
    try {
        initScrollReveal();
        console.log('✓ Scroll Reveal initialized');
    } catch (e) {
        console.warn('⚠ Scroll Reveal error:', e);
    }
    
    console.log('✅ All features initialized successfully!');
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
