@props(['label', 'name', 'value' => null, 'type' => 'text', 'hint' => null])

<x-admin.field :$label :$name :$hint>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @elseif ($hint) aria-describedby="{{ $name }}-hint" @endif
        {{ $attributes->class([
            'block w-full rounded-sm border bg-paper px-3 py-2 transition-colors outline-none placeholder:text-muted/70 focus:border-ink',
            'border-signal' => $errors->has($name),
            'border-line' => ! $errors->has($name),
        ]) }}
    >
</x-admin.field>
