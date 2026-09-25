<section id="about" class="container-page scroll-mt-14 py-24 md:py-36" aria-labelledby="about-title">
    <x-section-heading :$index label="About" />
    <h2 id="about-title" class="sr-only">About</h2>

    <div class="grid-page mt-10 gap-y-12 md:mt-16">
        @if ($profile->photo_path)
            <figure class="col-span-8 overflow-hidden rounded-sm bg-raised sm:col-span-5 md:col-span-3" data-parallax-frame>
                <x-image :path="$profile->photo_path" preset="profile_photo" :alt="$profile->name" sizes="(min-width: 768px) 25vw, 66vw" class="h-auto w-full scale-110 object-cover" data-parallax />
            </figure>
        @endif

        <div class="col-span-12 md:col-span-8 md:col-start-5">
            <div class="prose-content max-w-[62ch] text-lg leading-relaxed md:text-xl" data-reveal>
                {{ \App\Support\Markdown::render($profile->long_bio ?: $profile->short_bio) }}
            </div>

            <dl class="mt-16 grid grid-cols-3 border-t border-line">
                @foreach ([
                    ['value' => $projectCount, 'label' => Str::plural('Project', $projectCount)],
                    ['value' => $experiences->count(), 'label' => Str::plural('Role', $experiences->count())],
                    ['value' => $skills->count(), 'label' => 'Tools'],
                ] as $stat)
                    <div class="border-line pt-4 pr-4 [&:not(:first-child)]:border-l [&:not(:first-child)]:pl-4" data-reveal>
                        <dt class="label-mono text-muted">{{ $stat['label'] }}</dt>
                        <dd class="mt-2 font-display text-[clamp(3rem,7vw,6rem)] leading-none tabular-nums" data-counter="{{ $stat['value'] }}">{{ sprintf('%02d', $stat['value']) }}</dd>
                    </div>
                @endforeach
            </dl>

            @if ($profile->cv_path)
                <a href="{{ Storage::url($profile->cv_path) }}" class="label-mono link-underline mt-10 inline-flex items-center gap-2" download>
                    <x-icon name="download" :size="14" /> Download CV (PDF)
                </a>
            @endif
        </div>
    </div>
</section>
