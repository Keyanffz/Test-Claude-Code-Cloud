import { SplitText } from 'gsap/SplitText';
import { gsap, prefersReducedMotion } from './motion';

gsap.registerPlugin(SplitText);

export default function initHero(elements) {
    if (prefersReducedMotion) {
        gsap.fromTo(elements, { autoAlpha: 0 }, { autoAlpha: 1, duration: 0.4, stagger: 0.1 });
        return;
    }

    elements.forEach((element, index) => {
        SplitText.create(element, {
            type: 'lines,words',
            mask: 'lines',
            // Re-splits when fonts finish loading or the viewport resizes, so line breaks stay true.
            autoSplit: true,
            onSplit(split) {
                gsap.set(element, { autoAlpha: 1 });

                return gsap.from(split.words, {
                    yPercent: 110,
                    duration: 0.9,
                    ease: 'expo.out',
                    stagger: 0.06,
                    delay: 0.1 + index * 0.15,
                });
            },
        });
    });
}
