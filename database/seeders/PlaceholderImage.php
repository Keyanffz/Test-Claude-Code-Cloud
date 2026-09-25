<?php

namespace Database\Seeders;

use Intervention\Image\Geometry\Factories\LineFactory;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\ImageManager;

/**
 * Draws quiet, neutral placeholder artwork (tone field + construction lines) so seeded
 * content has real images to push through the upload pipeline without stock photos.
 */
class PlaceholderImage
{
    private const TONES = ['#e4e0d8', '#d8d4cb', '#cfcac0', '#2a2926', '#1a1918'];

    public static function make(int $width, int $height, int $seed): string
    {
        mt_srand($seed);

        $background = self::TONES[$seed % count(self::TONES)];
        $isDark = in_array($background, ['#2a2926', '#1a1918'], true);
        $stroke = $isDark ? '#3d3b37' : '#bdb8ad';
        $block = $isDark ? '#6b6862' : '#111110';

        $image = ImageManager::gd()->create($width, $height)->fill($background);

        $columns = 12;
        $columnWidth = $width / $columns;
        for ($i = 1; $i < $columns; $i++) {
            $x = (int) round($i * $columnWidth);
            $image->drawLine(fn (LineFactory $line) => $line->from($x, 0)->to($x, $height)->color($stroke)->width(1));
        }

        $baseline = (int) round($height * (0.55 + mt_rand(0, 20) / 100));
        $image->drawLine(fn (LineFactory $line) => $line->from(0, $baseline)->to($width, $baseline)->color($stroke)->width(2));

        $startColumn = mt_rand(1, 6);
        $spanColumns = mt_rand(3, 5);
        $blockHeight = (int) round($height * mt_rand(12, 30) / 100);
        $image->drawRectangle(
            (int) round($startColumn * $columnWidth),
            $baseline - $blockHeight,
            fn (RectangleFactory $rectangle) => $rectangle
                ->size((int) round($spanColumns * $columnWidth), $blockHeight)
                ->background($block),
        );

        $accentColumn = min($columns - 1, $startColumn + $spanColumns + 1);
        $image->drawRectangle(
            (int) round($accentColumn * $columnWidth),
            $baseline - (int) round($columnWidth),
            fn (RectangleFactory $rectangle) => $rectangle
                ->size((int) round($columnWidth), (int) round($columnWidth))
                ->background('#c2410c'),
        );

        $path = tempnam(sys_get_temp_dir(), 'placeholder').'.png';
        $image->toPng()->save($path);

        return $path;
    }
}
