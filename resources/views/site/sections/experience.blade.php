<section id="experience" class="container-page scroll-mt-14 py-24 md:py-36" aria-labelledby="experience-title">
    <x-section-heading :$index label="Experience" />
    <h2 id="experience-title" class="sr-only">Experience</h2>

    <ol class="grid-page mt-10 md:mt-16">
        @foreach ($experiences as $experience)
            <li class="group relative col-span-12 grid grid-cols-subgrid gap-y-3 pb-12 pl-6 last:pb-0 md:pl-0" data-reveal>
                {{-- Timeline rail: on mobile it runs down the left edge, on desktop it sits between date and content. --}}
                <span class="absolute top-2 bottom-0 left-[3px] w-px bg-line group-last:hidden md:left-[calc(25%+3px)]" aria-hidden="true"></span>
                <span @class([
                    'absolute top-1.5 left-0 size-[7px] rounded-full border md:left-[25%]',
                    'border-ink bg-ink' => $experience->isCurrent(),
                    'border-muted bg-paper' => ! $experience->isCurrent(),
                ]) aria-hidden="true"></span>

                <p class="label-mono col-span-12 text-muted tabular-nums md:col-span-3">
                    <time datetime="{{ $experience->started_at->format('Y-m') }}">{{ $experience->started_at->format('M Y') }}</time>
                    —
                    @if ($experience->isCurrent())
                        <span class="text-ink">Present</span>
                    @else
                        <time datetime="{{ $experience->ended_at->format('Y-m') }}">{{ $experience->ended_at->format('M Y') }}</time>
                    @endif
                </p>

                <div class="col-span-12 md:col-span-6 md:col-start-4 md:pl-10">
                    <h3 class="font-display text-[clamp(1.75rem,3.2vw,2.75rem)] leading-none">{{ $experience->position }}</h3>
                    <p class="mt-2 text-muted">{{ $experience->organization }}</p>
                    @if ($experience->description)
                        <p class="mt-4 max-w-[58ch] leading-relaxed">{{ $experience->description }}</p>
                    @endif
                </div>

                <p class="label-mono col-span-12 text-muted md:col-span-3 md:col-start-10 md:text-right">{{ $experience->type->label() }}</p>
            </li>
        @endforeach
    </ol>
</section>
