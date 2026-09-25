import Lenis from 'lenis';
import { gsap, ScrollTrigger, prefersReducedMotion } from './motion';

const HEADER_HEIGHT = 56;

export default function initLenis() {
    if (prefersReducedMotion) return;

    const lenis = new Lenis({
        duration: 1.1,
        easing: (t) => 1 - Math.pow(2, -10 * t),
        anchors: { offset: -HEADER_HEIGHT },
    });

    // One clock for both: Lenis advances on GSAP's ticker so ScrollTrigger never reads a stale position.
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);
}
