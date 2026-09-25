@props(['project', 'index'])

<li class="group border-b border-line" data-reveal>
    <a
        href="{{ route('projects.show', $project) }}"
        class="grid-page items-baseline gap-y-3 py-6 md:py-8"
        @if ($project->thumbnail_path) data-preview-src="{{ Storage::url($project->thumbnail_path) }}" @endif
    >
        <span class="label-mono col-span-2 self-start text-muted tabular-nums md:col-span-1 md:self-auto">{{ $index }}</span>

        @if ($project->thumbnail_path)
            <div class="col-span-10 overflow-hidden rounded-sm bg-raised md:hidden">
                <x-image :path="$project->thumbnail_path" preset="project_thumbnail" alt="" sizes="90vw" class="aspect-[4/3] h-auto w-full object-cover" />
            </div>
            <span class="col-span-2 md:hidden"></span>
        @endif

        <h3 class="col-span-10 font-display text-[clamp(2.5rem,6vw,5.5rem)] leading-[0.95] tracking-[-0.015em] transition-transform duration-500 ease-(--ease-out-expo) md:col-span-6 md:group-hover:translate-x-3">
            {{ $project->title }}
        </h3>

        <p class="col-span-10 col-start-3 text-muted md:col-span-3 md:col-start-8">
            {{ $project->role }}
            <span class="label-mono mt-1 block">{{ implode(' · ', array_slice($project->tech_stack, 0, 3)) }}</span>
        </p>

        <span class="label-mono col-span-10 col-start-3 flex items-center justify-between text-muted tabular-nums md:col-span-2 md:col-start-11 md:justify-end md:gap-3">
            {{ $project->year }}
            <x-icon name="arrow-up-right" class="text-ink transition-transform duration-500 ease-(--ease-out-expo) group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
        </span>
    </a>
</li>
