@props(['label', 'name', 'hint' => null, 'id' => null])

@php($errorKey = str_replace(['[', ']'], ['.', ''], $name))

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    <label for="{{ $id ?? $name }}" class="block font-medium">{{ $label }}</label>
    {{ $slot }}
    @if ($errors->has($errorKey) || $errors->has($errorKey.'.*'))
        <p class="flex items-center gap-1.5 text-signal" id="{{ $id ?? $name }}-error">
            <x-icon name="circle-alert" :size="14" />
            {{ $errors->first($errorKey) ?: $errors->first($errorKey.'.*') }}
        </p>
    @elseif ($hint)
        <p class="text-muted" id="{{ $id ?? $name }}-hint">{{ $hint }}</p>
    @endif
</div>
