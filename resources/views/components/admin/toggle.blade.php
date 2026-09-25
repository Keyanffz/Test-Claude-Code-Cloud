@props(['action', 'field', 'value', 'label'])

{{-- Optimistic switch: flips immediately, reverts if the request fails. --}}
<button
    type="button"
    role="switch"
    x-data="toggleSwitch('{{ $action }}', '{{ $field }}', @js((bool) $value))"
    @click="flip"
    :aria-checked="on"
    :disabled="busy"
    aria-label="{{ $label }}"
    class="relative inline-flex h-5 w-9 shrink-0 rounded-full border transition-colors"
    :class="on ? 'border-ink bg-ink' : 'border-line bg-raised'"
>
    <span class="absolute top-0.5 left-0.5 size-3.5 rounded-full transition-transform" :class="on ? 'translate-x-4 bg-paper' : 'bg-muted'"></span>
</button>
