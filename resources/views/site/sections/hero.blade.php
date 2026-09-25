@php
    // The ampersand is set in the serif italic, in the accent color: the one flourish in the hero.
    $headline = str_replace(' &amp; ', ' <em class="text-signal">&amp;</em> ', e($profile->headline));

    // A short nickname can fill the width; a full name has to step down a size to fit.
    $nameSize = mb_strlen($profile->displayName()) <= 6 ? 'text-[clamp(7rem,30vw,26rem)] leading-[0.78] tracking-[-0.04em]' : 'text-display';
@endphp

<section class="container-page flex min-h-[80svh] flex-col pt-6 pb-8 md:min-h-[calc(100svh-3.5rem)] md:pt-8" aria-labelledby="hero-title">
    <div class="grid-page label-mono text-muted" data-reveal>
        <p class="col-span-6 md:col-span-4">{{ $profile->name }}</p>
        @if ($profile->location)
            <p class="col-span-6 inline-flex items-center gap-1.5 justify-self-end md:col-span-3 md:col-start-10">
                <x-icon name="map-pin" :size="12" /> {{ $profile->location }}
            </p>
        @endif
    </div>

    <div class="grid-page flex-1 content-end gap-y-6 pt-16">
        <h1 id="hero-title" class="col-span-12 font-display {{ $nameSize }}" data-split>
            {{ $profile->displayName() }}
        </h1>

        <p class="col-span-12 font-display text-[clamp(1.75rem,3.6vw,3.25rem)] leading-[1.02] tracking-[-0.01em] md:col-span-8 md:col-start-5" data-split>
            {!! $headline !!}
        </p>
    </div>

    <div class="grid-page mt-10 gap-y-8 border-t border-line pt-6 md:mt-14">
        @if ($profile->short_bio)
            <p class="col-span-12 max-w-[46ch] text-base leading-relaxed text-muted md:col-span-6 lg:col-span-5 lg:text-lg" data-reveal>
                {{ $profile->short_bio }}
            </p>
        @endif

        <div class="col-span-12 flex flex-wrap items-center gap-x-8 gap-y-4 md:col-span-6 md:justify-self-end lg:col-span-5 lg:col-start-8" data-reveal>
            @if ($profile->open_to_work)
                <p class="label-mono inline-flex items-center gap-2">
                    <span class="size-1.5 rounded-full bg-signal"></span>
                    Open to work
                </p>
            @endif
            <a href="#contact" class="group inline-flex items-center gap-3 rounded-sm bg-ink px-5 py-3 text-paper" data-magnetic>
                <span data-magnetic-label>Get in touch</span>
                <x-icon name="arrow-right" class="transition-transform duration-300 ease-(--ease-out-power3) group-hover:translate-x-0.5" />
            </a>
        </div>
    </div>
</section>
