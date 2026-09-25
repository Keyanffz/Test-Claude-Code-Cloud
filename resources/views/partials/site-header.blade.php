@php
    $links = [
        ['label' => 'Work', 'href' => route('projects.index'), 'active' => request()->routeIs('projects.*')],
        ['label' => 'About', 'href' => route('home').'#about', 'active' => false],
        ['label' => 'Experience', 'href' => route('home').'#experience', 'active' => false],
        ['label' => 'Contact', 'href' => route('home').'#contact', 'active' => false],
    ];
@endphp

<header x-data="{ open: false }" @keydown.escape.window="open = false" class="sticky top-0 z-50 border-b border-line bg-paper">
    <div class="container-page grid-page h-14 items-center">
        <a href="{{ route('home') }}" class="col-span-6 flex items-baseline gap-2 md:col-span-3" aria-label="{{ $profile->displayName() }} — home">
            <span class="font-display text-2xl leading-none">{{ $profile->displayName() }}</span>
            <span class="label-mono hidden text-muted sm:inline">Portfolio</span>
        </a>

        <nav class="col-span-6 hidden items-center gap-8 md:flex" aria-label="Main">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" @class(['label-mono link-underline py-1', 'text-ink' => $link['active'], 'text-muted hover:text-ink' => ! $link['active']]) @if ($link['active']) aria-current="page" @endif>{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="col-span-6 flex items-center justify-end gap-4 md:col-span-3">
            @if ($profile->open_to_work)
                <span class="label-mono hidden items-center gap-2 text-muted lg:inline-flex">
                    <span class="relative flex size-1.5"><span class="absolute inset-0 animate-ping rounded-full bg-signal opacity-60 motion-reduce:hidden"></span><span class="relative size-1.5 rounded-full bg-signal"></span></span>
                    Available
                </span>
            @endif
            <x-theme-toggle class="-m-2 p-2 text-muted transition-colors hover:text-ink" />
            <button type="button" class="-m-2 p-2 md:hidden" @click="open = !open" :aria-expanded="open" aria-controls="mobile-nav">
                <span class="sr-only">Menu</span>
                <x-icon name="menu" :size="20" x-show="!open" />
                <x-icon name="x" :size="20" x-show="open" x-cloak />
            </button>
        </div>
    </div>

    <nav id="mobile-nav" x-show="open" x-cloak x-transition.opacity.duration.200ms class="border-t border-line bg-paper md:hidden" aria-label="Main">
        <ul class="container-page py-4">
            @foreach ($links as $index => $link)
                <li class="border-b border-line last:border-0">
                    <a href="{{ $link['href'] }}" @click="open = false" class="flex items-baseline justify-between py-4">
                        <span class="font-display text-4xl">{{ $link['label'] }}</span>
                        <span class="label-mono text-muted">{{ sprintf('%02d', $index + 1) }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</header>
