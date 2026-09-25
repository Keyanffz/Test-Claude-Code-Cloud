<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use InvalidArgumentException;

class ImageUploadService
{
    public function __construct(private readonly ImageManager $images) {}

    /**
     * Resize, crop and re-encode an upload (or a local file path) to WebP, writing the
     * full-size file plus one file per srcset variant.
     */
    public function store(UploadedFile|string $source, string $preset): StoredImage
    {
        $config = $this->preset($preset);
        $image = $this->images->read($source instanceof UploadedFile ? $source->getRealPath() : $source);

        $config['height']
            ? $image->cover($config['width'], $config['height'])
            : $image->scaleDown(width: $config['width']);

        $basename = $config['directory'].'/'.Str::ulid()->toBase32();
        $path = "{$basename}.webp";

        $this->write($path, $image);

        foreach ($config['variants'] as $width) {
            if ($width < $image->width()) {
                $this->write("{$basename}-{$width}.webp", (clone $image)->scaleDown(width: $width));
            }
        }

        return new StoredImage($path, $image->width(), $image->height());
    }

    /**
     * Delete a stored file and, for images, every srcset variant written next to it.
     */
    public function delete(?string $path): void
    {
        if (blank($path)) {
            return;
        }

        $disk = $this->disk();
        $disk->delete($path);

        if (str_ends_with($path, '.webp')) {
            $basename = Str::beforeLast($path, '.webp');
            $variants = array_filter(
                $disk->files(dirname($path)),
                fn (string $file) => preg_match('/^'.preg_quote($basename, '/').'-\d+\.webp$/', $file),
            );
            $disk->delete($variants);
        }
    }

    /**
     * @return array<int, array{url: string, width: int}>
     */
    public function sources(string $path, string $preset, int $width): array
    {
        $basename = Str::beforeLast($path, '.webp');
        $disk = $this->disk();

        return collect($this->preset($preset)['variants'])
            ->filter(fn (int $variant) => $variant < $width)
            ->map(fn (int $variant) => ['url' => $disk->url("{$basename}-{$variant}.webp"), 'width' => $variant])
            ->push(['url' => $disk->url($path), 'width' => $width])
            ->values()
            ->all();
    }

    /**
     * @return array{directory: string, width: int, height: int|null, variants: array<int, int>}
     */
    public function preset(string $name): array
    {
        return config("images.presets.{$name}")
            ?? throw new InvalidArgumentException("Unknown image preset [{$name}].");
    }

    private function write(string $path, ImageInterface $image): void
    {
        $this->disk()->put($path, (string) $image->toWebp(config('images.quality')));
    }

    private function disk(): Filesystem
    {
        return Storage::disk(config('images.disk'));
    }
}
