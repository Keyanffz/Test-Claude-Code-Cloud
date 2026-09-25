@props(['title', 'action' => null, 'actionLabel' => null])

<div class="border border-dashed border-line px-6 py-16">
    <p class="font-display text-3xl">{{ $title }}</p>
    @if ($slot->isNotEmpty())
        <p class="mt-2 max-w-md text-muted">{{ $slot }}</p>
    @endif
    @if ($action)
        <x-admin.button :href="$action" icon="plus" class="mt-6">{{ $actionLabel }}</x-admin.button>
    @endif
</div>
