@props(['label', 'name', 'type' => 'text', 'textarea' => false])

@php($invalid = $errors->has($name))

<div class="group">
    <label for="{{ $name }}" class="label-mono text-muted group-focus-within:text-ink">{{ $label }}</label>
    @if ($textarea)
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="5"
            @if ($invalid) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
            {{ $attributes->class(['mt-2 block w-full resize-y border-b bg-transparent py-2 text-lg outline-none focus:border-ink', 'border-signal' => $invalid, 'border-line' => ! $invalid]) }}
        >{{ old($name) }}</textarea>
    @else
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name) }}"
            @if ($invalid) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
            {{ $attributes->class(['mt-2 block w-full border-b bg-transparent py-2 text-lg outline-none focus:border-ink', 'border-signal' => $invalid, 'border-line' => ! $invalid]) }}
        >
    @endif
    @if ($invalid)
        <p id="{{ $name }}-error" class="mt-2 text-signal">{{ $errors->first($name) }}</p>
    @endif
</div>
