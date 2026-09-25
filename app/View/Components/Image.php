<?php

namespace App\View\Components;

use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;
use Illuminate\View\View;

class Image extends Component
{
    public int $renderWidth;

    public int $renderHeight;

    public function __construct(
        private readonly ImageUploadService $images,
        public ?string $path,
        public string $preset,
        public string $alt = '',
        public string $sizes = '100vw',
        public bool $eager = false,
        ?int $width = null,
        ?int $height = null,
    ) {
        $config = $images->preset($preset);

        // Cropped presets have fixed dimensions; free-aspect ones pass the stored size in.
        $this->renderWidth = $width ?? $config['width'];
        $this->renderHeight = $height ?? $config['height'] ?? $config['width'];
    }

    public function shouldRender(): bool
    {
        return filled($this->path);
    }

    public function src(): string
    {
        return Storage::disk(config('images.disk'))->url($this->path);
    }

    public function srcset(): string
    {
        return collect($this->images->sources($this->path, $this->preset, $this->renderWidth))
            ->map(fn (array $source) => "{$source['url']} {$source['width']}w")
            ->implode(', ');
    }

    public function render(): View
    {
        return view('components.image');
    }
}
