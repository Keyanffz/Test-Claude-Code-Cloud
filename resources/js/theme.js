export default () => ({
    theme: document.documentElement.dataset.theme,

    get label() {
        return this.theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
    },

    init() {
        // Follow the OS setting until the visitor makes an explicit choice.
        matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
            if (readStoredTheme() === null) {
                this.apply(event.matches ? 'dark' : 'light');
            }
        });
    },

    toggle() {
        const next = this.theme === 'dark' ? 'light' : 'dark';
        this.apply(next);
        try {
            localStorage.setItem('theme', next);
        } catch {
            // Private mode or blocked storage: the choice just won't persist.
        }
    },

    apply(theme) {
        this.theme = theme;
        document.documentElement.dataset.theme = theme;
    },
});

function readStoredTheme() {
    try {
        return localStorage.getItem('theme');
    } catch {
        return null;
    }
}
