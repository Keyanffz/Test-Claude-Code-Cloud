<section id="certificates" class="container-page scroll-mt-14 py-24 md:py-36" aria-labelledby="certificates-title">
    <x-section-heading :$index label="Certificates" />
    <h2 id="certificates-title" class="sr-only">Certificates</h2>

    <ul class="mt-6" data-preview-list>
        @foreach ($certificates as $certificate)
            @php($credential = $certificate->credentialUrl())
            <li class="border-b border-line" data-reveal>
                <{{ $credential ? 'a' : 'div' }}
                    @if ($credential) href="{{ $credential }}" target="_blank" rel="noopener" @endif
                    @if ($certificate->image_path) data-preview-src="{{ Storage::url($certificate->image_path) }}" @endif
                    class="group grid-page items-baseline gap-y-2 py-5"
                >
                    <span class="label-mono col-span-3 text-muted tabular-nums md:col-span-2 md:col-start-2">
                        <time datetime="{{ $certificate->issued_at->toDateString() }}">{{ $certificate->issued_at->format('M Y') }}</time>
                    </span>
                    <span class="col-span-9 text-lg md:col-span-5 md:text-xl">{{ $certificate->title }}</span>
                    <span class="col-span-9 col-start-4 text-muted md:col-span-3 md:col-start-8">{{ $certificate->issuer }}</span>
                    @if ($credential)
                        <span class="col-span-12 hidden justify-self-end md:col-span-1 md:block">
                            <x-icon name="arrow-up-right" class="transition-transform duration-500 ease-(--ease-out-expo) group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                            <span class="sr-only">(opens credential)</span>
                        </span>
                    @endif
                </{{ $credential ? 'a' : 'div' }}>
            </li>
        @endforeach
    </ul>
</section>
