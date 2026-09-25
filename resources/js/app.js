import Alpine from 'alpinejs';
import themeToggle from './theme';

Alpine.data('themeToggle', themeToggle);
window.Alpine = Alpine;
Alpine.start();

// Each effect is its own chunk, fetched only when the page has something for it to animate.
const animations = [
    ['[data-page-wipe]', () => import('./animations/page-transition')],
    ['body', () => import('./animations/lenis')],
    ['[data-split]', () => import('./animations/hero')],
    ['[data-reveal]', () => import('./animations/reveal')],
    ['[data-preview-list]', () => import('./animations/cursor-preview')],
    ['[data-magnetic]', () => import('./animations/magnetic')],
    ['[data-parallax]', () => import('./animations/parallax')],
    ['[data-marquee]', () => import('./animations/marquee')],
    ['[data-counter]', () => import('./animations/counter')],
];

const root = document.documentElement;

Promise.all(
    animations.map(async ([selector, load]) => {
        const elements = [...document.querySelectorAll(selector)];
        if (elements.length) {
            (await load()).default(elements);
        }
    }),
)
    .then(() => root.classList.add('motion-ready'))
    .catch(() => {
        // Never leave content hidden behind an animation that failed to start.
        root.classList.remove('js', 'is-wiping');
    });
