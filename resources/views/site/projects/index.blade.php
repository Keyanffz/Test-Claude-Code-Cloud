<x-layout title="Work" :description="'Projects by '.$profile->name.($activeStack ? ' built with '.$activeStack : '').'.'">
    <section class="container-page pt-10 pb-24 md:pt-16 md:pb-36" aria-labelledby="work-title">
        <div class="grid-page items-end gap-y-6">
            <p class="label-mono col-span-12 text-muted md:col-span-3" data-reveal>(Index) {{ sprintf('%02d', $total) }} projects</p>
            <h1 id="work-title" class="col-span-12 font-display text-display md:col-span-9" data-split>Work</h1>
        </div>

        <nav class="mt-12 flex flex-wrap items-center gap-x-5 gap-y-3 border-y border-line py-4" aria-label="Filter by technology" data-reveal>
            <span class="label-mono text-muted">Filter</span>
            <a href="{{ route('projects.index') }}" @class(['label-mono py-1', 'text-signal' => ! $activeStack, 'text-muted hover:text-ink' => $activeStack]) @if (! $activeStack) aria-current="page" @endif>All</a>
            @foreach ($technologies as $technology)
                <a
                    href="{{ route('projects.index', ['stack' => $technology]) }}"
                    @class(['label-mono py-1', 'text-signal' => $activeStack === $technology, 'text-muted hover:text-ink' => $activeStack !== $technology])
                    @if ($activeStack === $technology) aria-current="page" @endif
                >{{ $technology }}</a>
            @endforeach
        </nav>

        @if ($projects->isEmpty())
            <p class="mt-16 font-display text-4xl">Nothing here yet.</p>
        @else
            {{-- Alternating wide/narrow columns: an editorial rhythm instead of a uniform card grid. --}}
            <div class="grid-page mt-12 gap-y-16 md:mt-16 md:gap-y-24">
                @foreach ($projects as $project)
                    @php($wide = $loop->index % 4 === 0 || $loop->index % 4 === 3)
                    <x-project-card
                        :$project
                        :index="sprintf('%02d', $loop->iteration)"
                        :$wide
                        @class([
                            'col-span-12',
                            'md:col-span-7' => $wide,
                            'md:col-span-5' => ! $wide,
                            'md:mt-32' => ! $wide && $loop->index % 4 === 1,
                        ])
                    />
                @endforeach
            </div>
        @endif
    </section>
</x-layout>
