@props(['action', 'confirm' => 'Delete this item? This cannot be undone.', 'label' => 'Delete'])

<form method="POST" action="{{ $action }}" x-data @submit="if (! confirm(@js($confirm))) $event.preventDefault()" {{ $attributes }}>
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex items-center gap-1.5 p-1.5 text-muted transition-colors hover:text-signal" title="{{ $label }}">
        <x-icon name="trash-2" />
        <span class="sr-only">{{ $label }}</span>
    </button>
</form>
