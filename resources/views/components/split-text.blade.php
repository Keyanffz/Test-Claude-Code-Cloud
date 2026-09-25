@props(['text', 'accent' => null, 'delay' => 0])

{{--
    Words are split on the server and revealed with CSS, so the headline (usually the LCP
    element) paints on first frame instead of waiting for a JS bundle. Each word slides up
    behind its own mask; --i drives the stagger.
--}}
<span {{ $attributes->merge(['class' => 'split-text']) }} style="--split-delay: {{ $delay }}s">
    @foreach (preg_split('/\s+/u', trim((string) $text), -1, PREG_SPLIT_NO_EMPTY) as $word)
        <span class="split-word"><span class="split-inner" style="--i: {{ $loop->index }}">@if ($accent !== null && $word === $accent)<em class="text-signal">{{ $word }}</em>@else{{ $word }}@endif</span></span>{{ $loop->last ? '' : ' ' }}
    @endforeach
</span>
