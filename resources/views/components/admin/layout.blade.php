@props(['title'])

@php
    $navigation = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'layout-dashboard'],
        ['label' => 'Profile', 'route' => 'admin.profile.edit', 'match' => 'admin.profile.*', 'icon' => 'user'],
        ['label' => 'Projects', 'route' => 'admin.projects.index', 'match' => 'admin.projects.*', 'icon' => 'folder-kanban'],
        ['label' => 'Experience', 'route' => 'admin.experiences.index', 'match' => 'admin.experiences.*', 'icon' => 'briefcase'],
        ['label' => 'Skills', 'route' => 'admin.skills.index', 'match' => 'admin.skills.*', 'icon' => 'layers'],
        ['label' => 'Certificates', 'route' => 'admin.certificates.index', 'match' => 'admin.certificates.*', 'icon' => 'award'],
        ['label' => 'Social links', 'route' => 'admin.social-links.index', 'match' => 'admin.social-links.*', 'icon' => 'link'],
        ['label' => 'Messages', 'route' => 'admin.messages.index', 'match' => 'admin.messages.*', 'icon' => 'mail', 'badge' => $unreadMessages],
        ['label' => 'SEO', 'route' => 'admin.seo.edit', 'match' => 'admin.seo.*', 'icon' => 'globe'],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} · Admin</title>
    @include('partials.theme-script')
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
</head>
<body class="bg-paper text-[0.875rem] text-ink" x-data="{ navOpen: false }">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:bg-ink focus:px-3 focus:py-2 focus:text-paper">Skip to content</a>

    <div class="lg:grid lg:min-h-dvh lg:grid-cols-[240px_1fr]">
        <header class="sticky top-0 z-30 flex h-14 items-center justify-between border-b border-line bg-paper px-4 lg:hidden">
            <a href="{{ route('admin.dashboard') }}" class="font-display text-2xl">Admin</a>
            <button type="button" class="-mr-2 p-2" @click="navOpen = !navOpen" :aria-expanded="navOpen" aria-controls="admin-nav">
                <span class="sr-only">Toggle navigation</span>
                <x-icon name="menu" :size="20" x-show="!navOpen" />
                <x-icon name="x" :size="20" x-show="navOpen" x-cloak />
            </button>
        </header>

        <aside
            id="admin-nav"
            class="fixed inset-x-0 top-14 bottom-0 z-20 flex-col overflow-y-auto border-r border-line bg-paper lg:sticky lg:top-0 lg:flex lg:h-dvh"
            :class="navOpen ? 'flex' : 'hidden'"
        >
            <div class="hidden h-16 items-end border-b border-line px-6 pb-3 lg:flex">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-3xl leading-none">Admin</a>
            </div>

            <nav class="flex-1 px-3 py-4" aria-label="Admin">
                <ul class="space-y-px">
                    @foreach ($navigation as $item)
                        @php($active = request()->routeIs($item['match']))
                        <li>
                            <a
                                href="{{ route($item['route']) }}"
                                @class([
                                    'group flex items-center gap-3 rounded-sm px-3 py-2 transition-colors',
                                    'bg-ink text-paper' => $active,
                                    'text-muted hover:bg-raised hover:text-ink' => ! $active,
                                ])
                                @if ($active) aria-current="page" @endif
                            >
                                <x-icon :name="$item['icon']" />
                                <span class="flex-1">{{ $item['label'] }}</span>
                                @if (! empty($item['badge']))
                                    <span class="label-mono tabular-nums {{ $active ? 'text-paper' : 'text-signal' }}">{{ $item['badge'] }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="space-y-px border-t border-line px-3 py-4">
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-sm px-3 py-2 text-muted transition-colors hover:bg-raised hover:text-ink">
                    <x-icon name="external-link" />
                    View site
                </a>
                <x-theme-toggle class="flex w-full items-center gap-3 rounded-sm px-3 py-2 text-muted transition-colors hover:bg-raised hover:text-ink" with-label />
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-sm px-3 py-2 text-muted transition-colors hover:bg-raised hover:text-ink">
                        <x-icon name="log-out" />
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        <main id="main" class="min-w-0 px-4 py-8 sm:px-8 lg:px-12 lg:py-10">
            {{ $slot }}
        </main>
    </div>

    <x-admin.toasts />
</body>
</html>
