import Alpine from 'alpinejs';
import themeToggle from './theme';

Alpine.data('themeToggle', themeToggle);

window.Alpine = Alpine;
Alpine.start();
