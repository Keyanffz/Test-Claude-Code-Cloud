@props(['title', 'description', 'image', 'type', 'siteName'])

@php($imageUrl = $image ? Storage::url($image) : null)

<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ url()->current() }}">
@if ($imageUrl)
    <meta property="og:image" content="{{ url($imageUrl) }}">
@endif

<meta name="twitter:card" content="{{ $imageUrl ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if ($imageUrl)
    <meta name="twitter:image" content="{{ url($imageUrl) }}">
@endif
