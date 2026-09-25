<x-layout title="Not found">
    <section class="container-page flex min-h-[calc(100svh-3.5rem)] flex-col justify-between py-10">
        <div class="grid-page label-mono text-muted">
            <p class="col-span-6 md:col-span-3">(Error) 404</p>
            <p class="col-span-6 justify-self-end md:col-span-3 md:col-start-10">{{ '/'.ltrim(request()->path(), '/') }}</p>
        </div>

        <div class="grid-page items-end gap-y-8">
            <h1 class="col-span-12 font-display text-[clamp(8rem,34vw,30rem)] leading-[0.78] tracking-[-0.04em] md:col-span-8">
                <span class="split-text"><span class="split-word"><span class="split-inner">4<em class="text-signal">0</em>4</span></span></span>
            </h1>
            <div class="col-span-12 space-y-6 md:col-span-4 rise" style="--rise-delay: 0.4s">
                <p class="text-lg">This page is not in the index. It may have been renamed, unpublished, or never existed.</p>
                <div class="flex flex-wrap gap-x-6 gap-y-2">
                    <a href="{{ route('home') }}" class="link-underline inline-flex items-center gap-1.5"><x-icon name="arrow-left" :size="14" /> Home</a>
                    <a href="{{ route('projects.index') }}" class="link-underline inline-flex items-center gap-1.5">All work <x-icon name="arrow-right" :size="14" /></a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
