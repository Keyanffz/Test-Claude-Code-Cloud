<section id="skills" class="scroll-mt-14 py-24 md:py-36" aria-labelledby="skills-title">
    <div class="container-page">
        <x-section-heading :$index label="Skills & tools" />
        <h2 id="skills-title" class="sr-only">Skills and tools</h2>
    </div>

    {{-- Decorative repeat of the list below, so it is hidden from assistive tech. --}}
    <div class="mt-10 overflow-hidden border-y border-line py-6 md:mt-16 md:py-8" data-marquee aria-hidden="true">
        <div class="flex w-max" data-marquee-track>
            @foreach ([1, 2] as $copy)
                <ul class="flex shrink-0 items-center">
                    @foreach ($skills as $skill)
                        <li class="flex items-center font-display text-[clamp(2.5rem,6vw,5.5rem)] leading-none whitespace-nowrap">
                            <span class="px-6 md:px-10">{{ $skill->name }}</span>
                            <span class="size-2 rounded-full bg-ink/80 md:size-2.5"></span>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>

    <div class="container-page">
        <div class="grid-page mt-12 gap-y-10">
            @foreach ($skillsByCategory as $category => $categorySkills)
                <div @class(['col-span-6 md:col-span-3', 'md:col-start-4' => $loop->index % 3 === 0]) data-reveal>
                    <h3 class="label-mono border-b border-line pb-3 text-muted">{{ $category }}</h3>
                    <ul class="mt-4 space-y-1.5 text-lg">
                        @foreach ($categorySkills as $skill)
                            <li>{{ $skill->name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>
