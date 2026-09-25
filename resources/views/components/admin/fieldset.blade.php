@props(['legend', 'description' => null])

<fieldset {{ $attributes->merge(['class' => 'grid gap-6 border-t border-line pt-6 first:border-t-0 first:pt-0 md:grid-cols-[180px_1fr]']) }}>
    <div>
        <legend class="label-mono text-muted">{{ $legend }}</legend>
        @if ($description)
            <p class="mt-2 text-muted">{{ $description }}</p>
        @endif
    </div>
    <div class="space-y-6">{{ $slot }}</div>
</fieldset>
