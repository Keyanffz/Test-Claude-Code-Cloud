@php($editing = $project->exists)

<x-admin.layout :title="$editing ? $project->title : 'New project'">
    <x-admin.page-header :title="$editing ? $project->title : 'New project'" :back="route('admin.projects.index')">
        @if ($editing)
            <x-slot:actions>
                <x-admin.delete-button :action="route('admin.projects.destroy', $project)" :confirm="'Delete “'.$project->title.'” and all its images?'" label="Delete project" />
            </x-slot:actions>
        @endif
    </x-admin.page-header>

    <x-admin.form :action="$editing ? route('admin.projects.update', $project) : route('admin.projects.store')" :method="$editing ? 'PUT' : 'POST'" :submit="$editing ? 'Save changes' : 'Create project'" :cancel="route('admin.projects.index')">
        <x-admin.fieldset legend="Basics">
            <x-admin.input label="Title" name="title" :value="$project->title" required />
            <x-admin.input label="Slug" name="slug" :value="$project->slug" hint="Used in the URL: /projects/your-slug. Leave empty to generate it from the title." />
            <x-admin.textarea label="Summary" name="summary" :value="$project->summary" rows="3" maxlength="500" required hint="One or two sentences shown in project lists." />
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input label="Your role" name="role" :value="$project->role" />
                <x-admin.input label="Year" name="year" type="number" :value="$project->year" min="2000" :max="now()->year + 1" />
            </div>
            <x-admin.tags-input label="Tech stack" name="tech_stack" :value="$project->tech_stack ?? []" :suggestions="$techSuggestions" />
        </x-admin.fieldset>

        <x-admin.fieldset legend="Story">
            <x-admin.markdown label="Description" name="description" :value="$project->description" rows="16" />
        </x-admin.fieldset>

        <x-admin.fieldset legend="Links">
            <x-admin.input label="Live URL" name="live_url" type="url" :value="$project->live_url" placeholder="https://" />
            <x-admin.input label="Repository URL" name="repo_url" type="url" :value="$project->repo_url" placeholder="https://" />
        </x-admin.fieldset>

        <x-admin.fieldset legend="Images">
            <x-admin.image-input label="Thumbnail" name="thumbnail" :current="$project->thumbnail_path ? Storage::url($project->thumbnail_path) : null" hint="Cropped to 4:3. Shown in lists and as the hover preview." />

            @if ($editing && $project->images->isNotEmpty())
                <div class="space-y-2">
                    <p class="font-medium">Gallery</p>
                    <ul class="grid gap-4 sm:grid-cols-2">
                        @foreach ($project->images as $image)
                            <li class="space-y-2">
                                <div class="relative overflow-hidden rounded-sm bg-raised">
                                    <img src="{{ Storage::url($image->path) }}" alt="" width="{{ $image->width }}" height="{{ $image->height }}" loading="lazy" class="h-auto w-full">
                                    <button
                                        type="submit"
                                        form="delete-image-{{ $image->id }}"
                                        class="absolute top-2 right-2 inline-flex items-center gap-1 rounded-sm bg-ink px-2 py-1 text-paper hover:bg-signal"
                                    >
                                        <x-icon name="trash-2" :size="14" /> Remove
                                    </button>
                                </div>
                                <label for="image_alts_{{ $image->id }}" class="sr-only">Alt text</label>
                                <input
                                    id="image_alts_{{ $image->id }}"
                                    name="image_alts[{{ $image->id }}]"
                                    value="{{ old('image_alts.'.$image->id, $image->alt) }}"
                                    placeholder="Describe this image for screen readers"
                                    class="block w-full rounded-sm border border-line bg-paper px-3 py-2 outline-none focus:border-ink"
                                >
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <x-admin.field label="Add gallery images" name="gallery" hint="Select several at once. Up to {{ \App\Http\Requests\Admin\ProjectRequest::MAX_GALLERY_IMAGES }} per upload; each is resized and converted to WebP." x-data="{ count: 0 }">
                <label class="inline-flex cursor-pointer items-center gap-2 rounded-sm border border-line px-3 py-2 transition-colors hover:border-ink focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-signal">
                    <x-icon name="upload" />
                    <span x-text="count ? `${count} image${count > 1 ? 's' : ''} selected` : 'Choose images'">Choose images</span>
                    <input id="gallery" name="gallery[]" type="file" accept="image/jpeg,image/png,image/webp" multiple class="sr-only" @change="count = $event.target.files.length">
                </label>
            </x-admin.field>
        </x-admin.fieldset>

        <x-admin.fieldset legend="Visibility">
            <x-admin.checkbox label="Published" name="is_published" :checked="$project->is_published" hint="Unpublished projects are only visible here." />
            <x-admin.checkbox label="Featured" name="is_featured" :checked="$project->is_featured" hint="Featured projects are listed on the home page." />
        </x-admin.fieldset>
    </x-admin.form>

    {{-- Kept outside the main form: nested forms are invalid HTML. --}}
    @if ($editing)
        @foreach ($project->images as $image)
            <form id="delete-image-{{ $image->id }}" method="POST" action="{{ route('admin.projects.images.destroy', [$project, $image]) }}" x-data @submit="if (! confirm('Remove this image?')) $event.preventDefault()" hidden>
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
</x-admin.layout>
