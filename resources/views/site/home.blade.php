@php
    // Numbered in render order so hiding an empty section never leaves a gap in the index.
    $sections = collect([
        'about' => true,
        'work' => $featuredProjects->isNotEmpty(),
        'experience' => $experiences->isNotEmpty(),
        'skills' => $skills->isNotEmpty(),
        'certificates' => $certificates->isNotEmpty(),
        'contact' => true,
    ])->filter()->keys();
@endphp

<x-layout>
    <x-slot:head>
        <script type="application/ld+json">{!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $profile->name,
            'alternateName' => $profile->nickname,
            'jobTitle' => $profile->headline,
            'email' => $profile->email ? 'mailto:'.$profile->email : null,
            'address' => $profile->location,
            'url' => route('home'),
            'sameAs' => $socialLinks->pluck('url')->all(),
        ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    </x-slot:head>

    @include('site.sections.hero')

    @foreach ($sections as $position => $section)
        @include("site.sections.{$section}", ['index' => sprintf('%02d', $position + 1)])
    @endforeach
</x-layout>
