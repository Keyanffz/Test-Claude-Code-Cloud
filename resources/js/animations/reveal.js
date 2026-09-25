import { gsap, ScrollTrigger, prefersReducedMotion } from './motion';

export default function initReveal(elements) {
    ScrollTrigger.batch(elements, {
        start: 'top 88%',
        once: true,
        onEnter: (batch) =>
            gsap.to(batch, prefersReducedMotion
                ? { autoAlpha: 1, duration: 0.3 }
                : { autoAlpha: 1, y: 0, duration: 0.8, stagger: 0.08 }),
    });
}
