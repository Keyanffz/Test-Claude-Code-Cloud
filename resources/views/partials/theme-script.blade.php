{{-- Runs before first paint so the page never flashes the wrong theme. --}}
<script>
    (() => {
        let stored = null;
        try { stored = localStorage.getItem('theme'); } catch {}
        const theme = stored ?? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.dataset.theme = theme;
        document.documentElement.classList.add('js');
    })();
</script>
