@props(['label', 'name', 'current' => null, 'hint' => 'PDF up to 5 MB.'])

<x-admin.field :$label :$name :$hint x-data="{ fileName: '' }">
    <div class="flex flex-wrap items-center gap-3">
        <label class="inline-flex cursor-pointer items-center gap-2 rounded-sm border border-line px-3 py-2 transition-colors hover:border-ink focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-signal">
            <x-icon name="file-text" />
            <span x-text="fileName || 'Choose PDF'">Choose PDF</span>
            <input id="{{ $name }}" name="{{ $name }}" type="file" accept="application/pdf" class="sr-only" @change="fileName = $event.target.files[0]?.name ?? ''">
        </label>
        @if ($current)
            <a href="{{ $current }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-muted hover:text-ink">
                Current file <x-icon name="external-link" :size="14" />
            </a>
        @endif
    </div>
</x-admin.field>
