<x-admin.layout title="Skills">
    <x-admin.page-header title="Skills" description="Grouped by category on the site and repeated in the marquee. Drag to reorder.">
        <x-slot:actions>
            <x-admin.button :href="route('admin.skills.create')" icon="plus">Add skill</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if ($skills->isEmpty())
        <x-admin.empty-state title="No skills yet" :action="route('admin.skills.create')" action-label="Add skill" />
    @else
        <x-admin.table :sortable="route('admin.reorder', 'skills')" class="max-w-3xl">
            <x-slot:head>
                <th class="w-8 py-3"><span class="sr-only">Order</span></th>
                <th class="py-3 pr-4">Skill</th>
                <th class="py-3 pr-4">Category</th>
                <th class="py-3 text-right"><span class="sr-only">Actions</span></th>
            </x-slot:head>

            @foreach ($skills as $skill)
                <tr data-id="{{ $skill->id }}" class="bg-paper">
                    <td><x-admin.drag-handle /></td>
                    <td><a href="{{ route('admin.skills.edit', $skill) }}" class="font-medium hover:text-signal">{{ $skill->name }}</a></td>
                    <td class="label-mono text-muted">{{ $skill->category }}</td>
                    <td>
                        <div class="flex justify-end gap-1">
                            <x-admin.edit-link :href="route('admin.skills.edit', $skill)" />
                            <x-admin.delete-button :action="route('admin.skills.destroy', $skill)" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
