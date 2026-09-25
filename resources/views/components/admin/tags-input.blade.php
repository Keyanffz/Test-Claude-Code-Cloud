@props(['label', 'name', 'value' => [], 'hint' => 'Press Enter or comma to add. Backspace removes the last one.', 'suggestions' => []])

<x-admin.field :$label :$name :$hint id="{{ $name }}-entry" x-data="tagsInput({{ Js::from(array_values(old($name, $value) ?? [])) }})">
    <div class="flex flex-wrap items-center gap-1.5 rounded-sm border {{ $errors->has($name) || $errors->has($name.'.*') ? 'border-signal' : 'border-line' }} bg-paper px-2 py-1.5 focus-within:border-ink">
        <template x-for="(tag, index) in tags" :key="tag">
            <span class="inline-flex items-center gap-1 rounded-sm bg-raised py-0.5 pr-1 pl-2">
                <span x-text="tag"></span>
                <input type="hidden" name="{{ $name }}[]" :value="tag">
                <button type="button" class="text-muted hover:text-ink" @click="remove(index)" :aria-label="`Remove ${tag}`">
                    <x-icon name="x" :size="12" />
                </button>
            </span>
        </template>
        <input
            id="{{ $name }}-entry"
            type="text"
            x-model="entry"
            @keydown.enter.prevent="add"
            @keydown.comma.prevent="add"
            @keydown.backspace="entry === '' && tags.pop()"
            @blur="add"
            list="{{ $name }}-suggestions"
            class="min-w-32 flex-1 bg-transparent px-1 py-0.5 outline-none"
            autocomplete="off"
        >
        <datalist id="{{ $name }}-suggestions">
            @foreach ($suggestions as $suggestion)
                <option value="{{ $suggestion }}">
            @endforeach
        </datalist>
    </div>
</x-admin.field>
