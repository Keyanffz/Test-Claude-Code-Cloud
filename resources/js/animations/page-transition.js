import { gsap, prefersReducedMotion } from './motion';

const STORAGE_KEY = 'page-wipe';

/**
 * Fallback for browsers without cross-document View Transitions (those get a CSS-only
 * transition, see app.css): an ink panel wipes up before leaving and away after arriving.
 */
export default function initPageTransition([overlay]) {
    const root = document.documentElement;

    if (prefersReducedMotion || 'onpagereveal' in window) {
        root.classList.remove('is-wiping');
        return;
    }

    if (root.classList.contains('is-wiping')) {
        sessionStorage.removeItem(STORAGE_KEY);
        gsap.fromTo(overlay, { scaleY: 1, transformOrigin: 'top' }, {
            scaleY: 0,
            duration: 0.6,
            ease: 'expo.inOut',
            onComplete: () => root.classList.remove('is-wiping'),
        });
    }

    // Returning via the back button restores the page with the overlay still down.
    window.addEventListener('pageshow', (event) => event.persisted && gsap.set(overlay, { scaleY: 0 }));

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');
        if (!link || !isInternalNavigation(link, event)) return;

        event.preventDefault();
        sessionStorage.setItem(STORAGE_KEY, '1');
        gsap.fromTo(overlay, { scaleY: 0, transformOrigin: 'bottom' }, {
            scaleY: 1,
            duration: 0.5,
            ease: 'expo.inOut',
            onComplete: () => (window.location.href = link.href),
        });
    });
}

function isInternalNavigation(link, event) {
    const url = new URL(link.href);

    return event.button === 0
        && !event.metaKey && !event.ctrlKey && !event.shiftKey && !event.altKey
        && !link.target
        && !link.hasAttribute('download')
        && url.origin === location.origin
        && !url.pathname.startsWith('/storage/')
        && !(url.pathname === location.pathname && url.search === location.search && url.hash);
}
