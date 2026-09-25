@props(['label', 'name', 'value' => null, 'hint' => null, 'rows' => 4])

<x-admin.field :$label :$name :$hint>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @elseif ($hint) aria-describedby="{{ $name }}-hint" @endif
        {{ $attributes->class([
            'block w-full rounded-sm border bg-paper px-3 py-2 leading-relaxed transition-colors outline-none focus:border-ink',
            'border-signal' => $errors->has($name),
            'border-line' => ! $errors->has($name),
        ]) }}
    >{{ old($name, $value) }}</textarea>
</x-admin.field>
