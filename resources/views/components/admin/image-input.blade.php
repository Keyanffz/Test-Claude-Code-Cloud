@props(['label', 'name', 'current' => null, 'hint' => null, 'aspect' => 'aspect-[4/3]'])

@php($hint ??= 'JPG, PNG or WebP up to '.(config('images.max_upload_kb') / 1024).' MB, at least 200 × 200 px. Converted to WebP automatically.')

<x-admin.field :$label :$name :$hint x-data="imagePreview({{ Js::from($current) }}, {{ config('images.max_upload_kb') }})">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
        <div class="{{ $aspect }} w-full max-w-60 overflow-hidden rounded-sm border border-line bg-raised">
            <img x-show="src" :src="src" alt="" class="size-full object-cover" @if (! $current) x-cloak @endif>
            <div x-show="!src" class="flex size-full items-center justify-center text-muted" @if ($current) x-cloak @endif>
                <x-icon name="image" :size="24" />
            </div>
        </div>
        <div class="space-y-2">
            <label class="inline-flex cursor-pointer items-center gap-2 rounded-sm border border-line px-3 py-2 transition-colors hover:border-ink focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-signal">
                <x-icon name="upload" />
                <span x-text="fileName || 'Choose image'">Choose image</span>
                <input
                    id="{{ $name }}"
                    name="{{ $name }}"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    class="sr-only"
                    @change="preview($event)"
                    {{ $attributes }}
                >
            </label>
            <p x-show="error" x-text="error" class="text-signal" x-cloak></p>
        </div>
    </div>
</x-admin.field>
