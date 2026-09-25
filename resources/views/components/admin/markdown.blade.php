@props(['label', 'name', 'value' => null, 'hint' => 'Markdown: **bold**, *italic*, ## heading, - list, [link](https://…)', 'rows' => 12])

<x-admin.field :$label :$name :$hint x-data="markdownEditor('{{ route('admin.markdown.preview') }}')">
    <div class="overflow-hidden rounded-sm border {{ $errors->has($name) ? 'border-signal' : 'border-line' }} focus-within:border-ink">
        <div class="flex border-b border-line" role="tablist">
            <button type="button" role="tab" class="px-3 py-2" :aria-selected="tab === 'write'" :class="tab === 'write' ? 'text-ink' : 'text-muted hover:text-ink'" @click="tab = 'write'">Write</button>
            <button type="button" role="tab" class="px-3 py-2" :aria-selected="tab === 'preview'" :class="tab === 'preview' ? 'text-ink' : 'text-muted hover:text-ink'" @click="showPreview">Preview</button>
        </div>
        <textarea
            x-ref="source"
            x-show="tab === 'write'"
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            class="block w-full resize-y bg-paper px-3 py-2 font-mono text-[0.8125rem] leading-relaxed outline-none"
            {{ $attributes }}
        >{{ old($name, $value) }}</textarea>
        <div x-show="tab === 'preview'" x-cloak class="prose-content min-h-40 px-4 py-3">
            <p x-show="loading" class="text-muted">Rendering…</p>
            <div x-show="!loading" x-html="html"></div>
        </div>
    </div>
</x-admin.field>
