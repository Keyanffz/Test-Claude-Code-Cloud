import { gsap, hasFinePointer, prefersReducedMotion } from './motion';

const MAX_PULL = 12;

export default function initMagnetic(elements) {
    if (!hasFinePointer || prefersReducedMotion) return;

    elements.forEach((element) => {
        const label = element.querySelector('[data-magnetic-label]');

        element.addEventListener('pointermove', (event) => {
            const rect = element.getBoundingClientRect();
            const offsetX = (event.clientX - rect.left) / rect.width - 0.5;
            const offsetY = (event.clientY - rect.top) / rect.height - 0.5;

            gsap.to(element, { x: offsetX * MAX_PULL * 2, y: offsetY * MAX_PULL * 2, duration: 0.4 });
            if (label) gsap.to(label, { x: offsetX * MAX_PULL, y: offsetY * MAX_PULL, duration: 0.4 });
        });

        element.addEventListener('pointerleave', () => {
            gsap.to([element, label].filter(Boolean), { x: 0, y: 0, duration: 0.7, ease: 'expo.out' });
        });
    });
}
