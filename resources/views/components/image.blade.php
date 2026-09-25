<img
    src="{{ $src() }}"
    srcset="{{ $srcset() }}"
    sizes="{{ $sizes }}"
    alt="{{ $alt }}"
    width="{{ $renderWidth }}"
    height="{{ $renderHeight }}"
    @if ($eager) fetchpriority="high" @else loading="lazy" @endif
    decoding="async"
    {{ $attributes }}
>
