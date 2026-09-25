import Alpine from 'alpinejs';
import themeToggle from './theme';
import toasts from './admin/toasts';
import sortableList from './admin/sortable-list';
import toggleSwitch from './admin/toggle-switch';
import imagePreview from './admin/image-preview';
import markdownEditor from './admin/markdown-editor';
import tagsInput from './admin/tags-input';

Alpine.data('themeToggle', themeToggle);
Alpine.data('toasts', toasts);
Alpine.data('sortableList', sortableList);
Alpine.data('toggleSwitch', toggleSwitch);
Alpine.data('imagePreview', imagePreview);
Alpine.data('markdownEditor', markdownEditor);
Alpine.data('tagsInput', tagsInput);

window.Alpine = Alpine;
Alpine.start();
