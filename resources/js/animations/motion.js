import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);
gsap.defaults({ ease: 'power3.out', duration: 0.8 });

export { gsap, ScrollTrigger };

export const prefersReducedMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;

// Cursor-driven effects only make sense with a precise pointer and room to move it.
export const hasFinePointer = matchMedia('(hover: hover) and (pointer: fine) and (min-width: 768px)').matches;
