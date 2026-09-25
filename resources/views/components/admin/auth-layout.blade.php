@props(['title'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} · Admin</title>
    @include('partials.theme-script')
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
</head>
<body class="bg-paper text-[0.875rem] text-ink">
    <main class="grid min-h-dvh lg:grid-cols-2">
        <div class="hidden flex-col justify-between border-r border-line p-12 lg:flex">
            <a href="{{ route('home') }}" class="label-mono text-muted hover:text-ink">← Back to site</a>
            <p class="font-display text-[clamp(4rem,8vw,8rem)] leading-[0.85] tracking-tight">Edit<br><em class="text-signal">quietly.</em></p>
        </div>
        <div class="flex items-center px-6 py-16 sm:px-12">
            <div class="w-full max-w-sm">
                {{ $slot }}
            </div>
        </div>
    </main>
</body>
</html>
