import { gsap, prefersReducedMotion } from './motion';

export default function initParallax(images) {
    if (prefersReducedMotion) return;

    images.forEach((image) => {
        // The image is scaled to 110% in CSS, so ±4% travel never exposes the frame edge.
        gsap.fromTo(image, { yPercent: -4 }, {
            yPercent: 4,
            ease: 'none',
            scrollTrigger: {
                trigger: image.closest('[data-parallax-frame]') ?? image,
                start: 'top bottom',
                end: 'bottom top',
                scrub: true,
            },
        });
    });
}
