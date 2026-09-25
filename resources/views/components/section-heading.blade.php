@props(['index', 'label', 'title' => null])

<div {{ $attributes->merge(['class' => 'grid-page items-baseline gap-y-4 border-t border-ink pt-4']) }}>
    <p class="label-mono col-span-12 flex gap-3 text-muted md:col-span-3" data-reveal>
        <span class="tabular-nums">({{ $index }})</span>
        <span>{{ $label }}</span>
    </p>
    @if ($title)
        <h2 class="col-span-12 font-display text-title md:col-span-9" data-reveal>{{ $title }}</h2>
    @endif
    {{ $slot }}
</div>
