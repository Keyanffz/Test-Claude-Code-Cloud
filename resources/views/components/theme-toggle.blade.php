@props(['withLabel' => false])

<button type="button" x-data="themeToggle" @click="toggle" {{ $attributes }} :aria-label="label" :title="label">
    <x-icon name="moon" x-show="theme === 'light'" />
    <x-icon name="sun" x-show="theme === 'dark'" x-cloak />
    @if ($withLabel)
        <span x-text="theme === 'dark' ? 'Light mode' : 'Dark mode'">Theme</span>
    @endif
</button>
