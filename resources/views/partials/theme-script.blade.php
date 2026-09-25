{{-- Runs before first paint so the page never flashes the wrong theme or unhidden animation targets. --}}
<script>
    (() => {
        const root = document.documentElement;
        let stored = null;
        try { stored = localStorage.getItem('theme'); } catch {}
        root.dataset.theme = stored ?? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        root.classList.add('js');
        try { if (sessionStorage.getItem('page-wipe')) root.classList.add('is-wiping'); } catch {}
        // If the animation bundle never arrives, show the content anyway.
        setTimeout(() => root.classList.contains('motion-ready') || root.classList.remove('js', 'is-wiping'), 4000);
    })();
</script>
