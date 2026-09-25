@props(['label', 'name', 'options', 'value' => null, 'hint' => null])

<x-admin.field :$label :$name :$hint>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->class([
            'block w-full rounded-sm border bg-paper px-3 py-2 outline-none focus:border-ink',
            'border-signal' => $errors->has($name),
            'border-line' => ! $errors->has($name),
        ]) }}
    >
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) old($name, $value) === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>
</x-admin.field>
