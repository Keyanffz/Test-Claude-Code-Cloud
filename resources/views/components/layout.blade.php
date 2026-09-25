@props(['title' => null, 'description' => null, 'image' => null, 'type' => 'website'])

@php
    $pageTitle = $title ? "{$title} — {$profile->displayName()}" : ($seo->meta_title ?: $profile->displayName());
    $pageDescription = $description ?: $seo->meta_description ?: $profile->short_bio;
    $pageImage = $image ?: $seo->og_image_path;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <x-seo :title="$pageTitle" :description="$pageDescription" :image="$pageImage" :type="$type" :site-name="$profile->name" />
    <meta name="theme-color" content="#f2f0eb" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#111110" media="(prefers-color-scheme: dark)">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    {{ $head ?? '' }}
    @include('partials.theme-script')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-paper text-ink">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:bg-ink focus:px-3 focus:py-2 focus:text-paper">Skip to content</a>

    @include('partials.site-header')

    <main id="main">
        {{ $slot }}
    </main>

    @include('partials.site-footer')

    <div data-page-wipe class="pointer-events-none fixed inset-0 z-[70] origin-bottom scale-y-0 bg-ink" aria-hidden="true"></div>
</body>
</html>
