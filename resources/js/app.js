import './bootstrap';
import Alpine from 'alpinejs';
import { initializeAllFeatures } from './init-features';

window.Alpine = Alpine;
Alpine.start();

// Initialize all features
initializeAllFeatures();
