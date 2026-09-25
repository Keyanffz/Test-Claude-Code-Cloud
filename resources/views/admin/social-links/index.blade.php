<x-admin.layout title="Social links">
    <x-admin.page-header title="Social links" description="Shown in the contact section and the footer, in this order.">
        <x-slot:actions>
            <x-admin.button :href="route('admin.social-links.create')" icon="plus">Add link</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if ($socialLinks->isEmpty())
        <x-admin.empty-state title="No links yet" :action="route('admin.social-links.create')" action-label="Add link" />
    @else
        <x-admin.table :sortable="route('admin.reorder', 'social-links')" class="max-w-3xl">
            <x-slot:head>
                <th class="w-8 py-3"><span class="sr-only">Order</span></th>
                <th class="py-3 pr-4">Platform</th>
                <th class="py-3 pr-4">URL</th>
                <th class="py-3 text-right"><span class="sr-only">Actions</span></th>
            </x-slot:head>

            @foreach ($socialLinks as $socialLink)
                <tr data-id="{{ $socialLink->id }}" class="bg-paper">
                    <td><x-admin.drag-handle /></td>
                    <td><a href="{{ route('admin.social-links.edit', $socialLink) }}" class="font-medium hover:text-signal">{{ $socialLink->platform }}</a></td>
                    <td class="max-w-xs truncate font-mono text-[0.8125rem] text-muted">{{ $socialLink->url }}</td>
                    <td>
                        <div class="flex justify-end gap-1">
                            <x-admin.edit-link :href="route('admin.social-links.edit', $socialLink)" />
                            <x-admin.delete-button :action="route('admin.social-links.destroy', $socialLink)" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
