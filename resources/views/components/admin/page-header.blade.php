@props(['title', 'description' => null, 'back' => null])

<header class="mb-8 flex flex-wrap items-end justify-between gap-4 border-b border-line pb-6">
    <div class="space-y-2">
        @if ($back)
            <a href="{{ $back }}" class="inline-flex items-center gap-1.5 text-muted hover:text-ink">
                <x-icon name="arrow-left" :size="14" /> Back
            </a>
        @endif
        <h1 class="font-display text-4xl leading-none sm:text-5xl">{{ $title }}</h1>
        @if ($description)
            <p class="max-w-xl text-muted">{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
    @endisset
</header>
