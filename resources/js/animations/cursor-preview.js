import { gsap, hasFinePointer, prefersReducedMotion } from './motion';

const WIDTH = 320;

export default function initCursorPreview(lists) {
    if (!hasFinePointer || prefersReducedMotion) return;

    const figure = document.createElement('figure');
    figure.className = 'pointer-events-none fixed top-0 left-0 z-40 aspect-[4/3] overflow-hidden rounded-sm bg-raised';
    figure.style.width = `${WIDTH}px`;
    figure.setAttribute('aria-hidden', 'true');
    const image = document.createElement('img');
    image.className = 'size-full object-cover';
    image.alt = '';
    figure.append(image);
    document.body.append(figure);

    gsap.set(figure, { autoAlpha: 0, scale: 0.85, xPercent: -50, yPercent: -50 });
    const moveX = gsap.quickTo(figure, 'x', { duration: 0.5, ease: 'power3.out' });
    const moveY = gsap.quickTo(figure, 'y', { duration: 0.5, ease: 'power3.out' });

    lists.forEach((list) => {
        const items = list.querySelectorAll('[data-preview-src]');
        if (!items.length) return;

        // Warm the cache on first approach so the image is there before the hover.
        list.addEventListener('pointerenter', () => items.forEach((item) => (new Image().src = item.dataset.previewSrc)), { once: true });

        list.addEventListener('pointermove', (event) => {
            moveX(event.clientX + WIDTH * 0.6);
            moveY(event.clientY);
        });

        items.forEach((item) => {
            item.addEventListener('pointerenter', () => {
                image.src = item.dataset.previewSrc;
                gsap.to(figure, { autoAlpha: 1, scale: 1, duration: 0.5, ease: 'expo.out' });
            });
            item.addEventListener('pointerleave', () => {
                gsap.to(figure, { autoAlpha: 0, scale: 0.85, duration: 0.4 });
            });
        });
    });
}
