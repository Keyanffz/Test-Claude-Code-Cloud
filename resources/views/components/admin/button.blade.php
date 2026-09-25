@props(['variant' => 'primary', 'href' => null, 'icon' => null])

@php
    $classes = [
        'primary' => 'bg-ink text-paper hover:bg-ink/85 border-ink',
        'secondary' => 'border-line text-ink hover:border-ink',
        'danger' => 'border-line text-signal hover:border-signal',
    ][$variant];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class("inline-flex items-center justify-center gap-2 rounded-sm border px-4 py-2 font-medium transition-colors $classes") }}>
        @if ($icon) <x-icon :name="$icon" /> @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit'])->class("inline-flex items-center justify-center gap-2 rounded-sm border px-4 py-2 font-medium transition-colors disabled:opacity-50 $classes") }}>
        @if ($icon) <x-icon :name="$icon" /> @endif
        {{ $slot }}
    </button>
@endif
