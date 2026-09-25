import { gsap, ScrollTrigger, prefersReducedMotion } from './motion';

const PIXELS_PER_SECOND = 40;

export default function initMarquee(marquees) {
    if (prefersReducedMotion) return;

    marquees.forEach((marquee) => {
        const track = marquee.querySelector('[data-marquee-track]');
        const loopWidth = track.scrollWidth / 2;

        const tween = gsap.to(track, {
            x: -loopWidth,
            duration: loopWidth / PIXELS_PER_SECOND,
            ease: 'none',
            repeat: -1,
        });

        // Ease to a stop rather than freezing mid-frame; it reads as deliberate.
        marquee.addEventListener('pointerenter', () => gsap.to(tween, { timeScale: 0, duration: 0.6 }));
        marquee.addEventListener('pointerleave', () => gsap.to(tween, { timeScale: 1, duration: 0.6 }));

        ScrollTrigger.create({
            trigger: marquee,
            onToggle: ({ isActive }) => (isActive ? tween.play() : tween.pause()),
        });
    });
}
