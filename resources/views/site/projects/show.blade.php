<x-layout :title="$project->title" :description="$project->summary" :image="$project->thumbnail_path" type="article">
    <article class="container-page pt-8 pb-24 md:pt-12" aria-labelledby="project-title">
        <div class="grid-page label-mono text-muted rise">
            <a href="{{ route('projects.index') }}" class="col-span-6 inline-flex items-center gap-1.5 hover:text-ink md:col-span-3">
                <x-icon name="arrow-left" :size="12" /> All work
            </a>
            <p class="col-span-6 justify-self-end tabular-nums md:col-span-3 md:col-start-10">{{ sprintf('%02d', $position) }} / {{ sprintf('%02d', $total) }}</p>
        </div>

        <header class="grid-page mt-16 gap-y-8 md:mt-24">
            <h1 id="project-title" class="col-span-12 font-display text-display"><x-split-text :text="$project->title" /></h1>
            <p class="col-span-12 text-xl leading-snug md:col-span-7 md:col-start-4 md:text-2xl rise" style="--rise-delay: 0.4s">{{ $project->summary }}</p>
        </header>

        <dl class="grid-page mt-16 gap-y-6 border-t border-line pt-6 rise" style="--rise-delay: 0.5s">
            @foreach (array_filter(['Role' => $project->role, 'Year' => $project->year]) as $term => $detail)
                <div class="col-span-6 md:col-span-3 {{ $loop->first ? 'md:col-start-4' : '' }}">
                    <dt class="label-mono text-muted">{{ $term }}</dt>
                    <dd class="mt-2 tabular-nums">{{ $detail }}</dd>
                </div>
            @endforeach
            <div class="col-span-12 md:col-span-3">
                <dt class="label-mono text-muted">Stack</dt>
                <dd class="mt-2">{{ implode(', ', $project->tech_stack) }}</dd>
            </div>
            @if ($project->live_url || $project->repo_url)
                <div class="col-span-12 flex flex-wrap gap-x-6 gap-y-2 md:col-span-9 md:col-start-4">
                    <dt class="sr-only">Links</dt>
                    @if ($project->live_url)
                        <dd><a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="link-underline inline-flex items-center gap-1">Visit live site <x-icon name="arrow-up-right" :size="14" /></a></dd>
                    @endif
                    @if ($project->repo_url)
                        <dd><a href="{{ $project->repo_url }}" target="_blank" rel="noopener" class="link-underline inline-flex items-center gap-1">Source code <x-icon name="arrow-up-right" :size="14" /></a></dd>
                    @endif
                </div>
            @endif
        </dl>

        @if ($project->thumbnail_path)
            <figure class="mt-16 overflow-hidden rounded-sm bg-raised md:mt-24" data-parallax-frame>
                <x-image :path="$project->thumbnail_path" preset="project_thumbnail" :alt="$project->title" sizes="(min-width: 1440px) 1328px, 100vw" eager class="aspect-[4/3] h-auto w-full scale-110 object-cover md:aspect-[16/9]" data-parallax />
            </figure>
        @endif

        @if ($project->description)
            <div class="grid-page mt-16 md:mt-24">
                <p class="label-mono col-span-12 mb-6 text-muted md:col-span-3 md:mb-0" data-reveal>About the project</p>
                <div class="prose-content col-span-12 max-w-[64ch] text-lg md:col-span-7 md:col-start-4" data-reveal>
                    {{ \App\Support\Markdown::render($project->description) }}
                </div>
            </div>
        @endif

        @if ($project->images->isNotEmpty())
            <div class="grid-page mt-16 gap-y-6 md:mt-24 md:gap-y-8">
                @foreach ($project->images as $image)
                    <figure @class([
                        'overflow-hidden rounded-sm bg-raised',
                        'col-span-12' => $loop->index % 3 === 0,
                        'col-span-12 md:col-span-6' => $loop->index % 3 !== 0,
                    ]) data-reveal>
                        <x-image :path="$image->path" preset="project_gallery" :alt="$image->alt ?? ''" :width="$image->width" :height="$image->height" :sizes="$loop->index % 3 === 0 ? '100vw' : '(min-width: 768px) 50vw, 100vw'" class="h-auto w-full" />
                    </figure>
                @endforeach
            </div>
        @endif
    </article>

    @if ($previous && $next)
        <nav class="border-t border-line" aria-label="More projects">
            <div class="container-page grid md:grid-cols-2">
                <a href="{{ route('projects.show', $previous) }}" class="group border-b border-line py-10 md:border-r md:border-b-0 md:pr-8">
                    <span class="label-mono inline-flex items-center gap-1.5 text-muted"><x-icon name="arrow-left" :size="12" /> Previous</span>
                    <span class="mt-3 block font-display text-[clamp(2rem,4vw,3.5rem)] leading-none transition-transform duration-500 ease-(--ease-out-expo) group-hover:-translate-x-2">{{ $previous->title }}</span>
                </a>
                <a href="{{ route('projects.show', $next) }}" class="group py-10 text-right md:pl-8">
                    <span class="label-mono inline-flex items-center gap-1.5 text-muted">Next <x-icon name="arrow-right" :size="12" /></span>
                    <span class="mt-3 block font-display text-[clamp(2rem,4vw,3.5rem)] leading-none transition-transform duration-500 ease-(--ease-out-expo) group-hover:translate-x-2">{{ $next->title }}</span>
                </a>
            </div>
        </nav>
    @endif
</x-layout>
