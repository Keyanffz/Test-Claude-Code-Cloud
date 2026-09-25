@props(['label', 'name', 'checked' => false, 'hint' => null])

<div {{ $attributes->merge(['class' => 'flex items-start gap-3']) }}>
    <input type="hidden" name="{{ $name }}" value="0">
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="checkbox"
        value="1"
        @checked(old($name, $checked))
        class="peer sr-only"
    >
    <label for="{{ $name }}" class="relative mt-0.5 inline-flex h-5 w-9 shrink-0 rounded-full border border-line bg-raised transition-colors peer-checked:border-ink peer-checked:bg-ink peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-signal after:absolute after:top-0.5 after:left-0.5 after:size-3.5 after:rounded-full after:bg-muted after:transition-transform peer-checked:after:translate-x-4 peer-checked:after:bg-paper">
        <span class="sr-only">{{ $label }}</span>
    </label>
    <div>
        <label for="{{ $name }}" class="font-medium">{{ $label }}</label>
        @if ($hint)
            <p class="text-muted">{{ $hint }}</p>
        @endif
    </div>
</div>
