@props(['href', 'label' => 'Edit'])

<a href="{{ $href }}" class="inline-flex items-center p-1.5 text-muted transition-colors hover:text-ink" title="{{ $label }}">
    <x-icon name="pencil" />
    <span class="sr-only">{{ $label }}</span>
</a>
