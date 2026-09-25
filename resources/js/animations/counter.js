import { gsap, ScrollTrigger, prefersReducedMotion } from './motion';

const format = (value) => String(Math.round(value)).padStart(2, '0');

export default function initCounter(elements) {
    if (prefersReducedMotion) return;

    elements.forEach((element) => {
        const target = Number(element.dataset.counter);
        const state = { value: 0 };
        element.textContent = format(0);

        ScrollTrigger.create({
            trigger: element,
            start: 'top 90%',
            once: true,
            onEnter: () =>
                gsap.to(state, {
                    value: target,
                    duration: 0.9,
                    ease: 'expo.out',
                    onUpdate: () => (element.textContent = format(state.value)),
                }),
        });
    });
}
