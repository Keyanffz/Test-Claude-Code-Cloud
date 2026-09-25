<x-admin.layout title="Experience">
    <x-admin.page-header title="Experience" description="Shown as a timeline on the home page, in the order below.">
        <x-slot:actions>
            <x-admin.button :href="route('admin.experiences.create')" icon="plus">Add experience</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if ($experiences->isEmpty())
        <x-admin.empty-state title="No experience yet" :action="route('admin.experiences.create')" action-label="Add experience" />
    @else
        <x-admin.table :sortable="route('admin.reorder', 'experiences')">
            <x-slot:head>
                <th class="w-8 py-3"><span class="sr-only">Order</span></th>
                <th class="py-3 pr-4">Position</th>
                <th class="py-3 pr-4">Type</th>
                <th class="py-3 pr-4">Period</th>
                <th class="py-3 text-right"><span class="sr-only">Actions</span></th>
            </x-slot:head>

            @foreach ($experiences as $experience)
                <tr data-id="{{ $experience->id }}" class="bg-paper">
                    <td><x-admin.drag-handle /></td>
                    <td>
                        <a href="{{ route('admin.experiences.edit', $experience) }}" class="font-medium hover:text-signal">{{ $experience->position }}</a>
                        <p class="text-muted">{{ $experience->organization }}</p>
                    </td>
                    <td class="label-mono text-muted">{{ $experience->type->label() }}</td>
                    <td class="font-mono text-[0.8125rem] tabular-nums text-muted">{{ $experience->period() }}</td>
                    <td>
                        <div class="flex justify-end gap-1">
                            <x-admin.edit-link :href="route('admin.experiences.edit', $experience)" />
                            <x-admin.delete-button :action="route('admin.experiences.destroy', $experience)" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
