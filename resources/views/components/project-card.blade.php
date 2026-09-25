@props(['project', 'index', 'wide' => false])

<article {{ $attributes->class(['group relative']) }} data-reveal>
    <div @class(['overflow-hidden rounded-sm bg-raised', 'aspect-[4/3]' => ! $wide, 'aspect-[4/3] md:aspect-[16/10]' => $wide]) data-parallax-frame>
        <x-image
            :path="$project->thumbnail_path"
            preset="project_thumbnail"
            alt=""
            :sizes="$wide ? '(min-width: 768px) 58vw, 100vw' : '(min-width: 768px) 42vw, 100vw'"
            class="size-full scale-110 object-cover transition-[filter] duration-700 group-hover:brightness-95"
            data-parallax
        />
    </div>

    <div class="mt-4 grid grid-cols-[auto_1fr_auto] items-baseline gap-x-4 border-t border-line pt-3">
        <span class="label-mono text-muted tabular-nums">{{ $index }}</span>
        <h2 class="font-display text-[clamp(1.75rem,3vw,2.75rem)] leading-none">
            <a href="{{ route('projects.show', $project) }}" class="after:absolute after:inset-0">{{ $project->title }}</a>
        </h2>
        <span class="label-mono text-muted tabular-nums">{{ $project->year }}</span>
        <p class="col-start-2 mt-3 max-w-[52ch] text-muted">{{ $project->summary }}</p>
        <p class="label-mono col-start-2 mt-3">{{ implode(' · ', $project->tech_stack) }}</p>
    </div>
</article>
