<x-admin.layout title="Projects">
    <x-admin.page-header title="Projects" description="Drag rows to change the order on the site. Switches save immediately.">
        <x-slot:actions>
            <x-admin.button :href="route('admin.projects.create')" icon="plus">New project</x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if ($projects->isEmpty())
        <x-admin.empty-state title="No projects yet" :action="route('admin.projects.create')" action-label="Add the first project">
            Projects appear on the home page (when featured) and on /projects once published.
        </x-admin.empty-state>
    @else
        <x-admin.table :sortable="route('admin.reorder', 'projects')">
            <x-slot:head>
                <th class="w-8 py-3"><span class="sr-only">Order</span></th>
                <th class="py-3 pr-4">Project</th>
                <th class="py-3 pr-4">Year</th>
                <th class="py-3 pr-4">Published</th>
                <th class="py-3 pr-4">Featured</th>
                <th class="py-3 text-right"><span class="sr-only">Actions</span></th>
            </x-slot:head>

            @foreach ($projects as $project)
                <tr data-id="{{ $project->id }}" class="bg-paper">
                    <td><x-admin.drag-handle /></td>
                    <td>
                        <div class="flex items-center gap-4">
                            <div class="aspect-[4/3] w-16 shrink-0 overflow-hidden rounded-sm bg-raised">
                                @if ($project->thumbnail_path)
                                    <img src="{{ Storage::url($project->thumbnail_path) }}" alt="" width="64" height="48" loading="lazy" class="size-full object-cover">
                                @endif
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="font-medium hover:text-signal">{{ $project->title }}</a>
                                <p class="label-mono mt-1 truncate text-muted">{{ implode(' · ', $project->tech_stack) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="font-mono tabular-nums text-muted">{{ $project->year ?? '—' }}</td>
                    <td><x-admin.toggle :action="route('admin.projects.visibility', $project)" field="is_published" :value="$project->is_published" :label="'Publish '.$project->title" /></td>
                    <td><x-admin.toggle :action="route('admin.projects.visibility', $project)" field="is_featured" :value="$project->is_featured" :label="'Feature '.$project->title" /></td>
                    <td>
                        <div class="flex justify-end gap-1">
                            @if ($project->is_published)
                                <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener" class="p-1.5 text-muted hover:text-ink" title="View on site">
                                    <x-icon name="eye" /><span class="sr-only">View on site</span>
                                </a>
                            @endif
                            <x-admin.edit-link :href="route('admin.projects.edit', $project)" />
                            <x-admin.delete-button :action="route('admin.projects.destroy', $project)" :confirm="'Delete “'.$project->title.'” and all its images?'" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin.table>
    @endif
</x-admin.layout>
