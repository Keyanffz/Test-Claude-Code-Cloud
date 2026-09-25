<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Inline Lucide icon. SVG bodies live in resources/icons (copied from lucide-static)
 * so no icon font or runtime JS is shipped.
 */
class Icon extends Component
{
    /** @var array<string, string> */
    private static array $cache = [];

    public function __construct(
        public string $name,
        public int $size = 16,
    ) {}

    public function body(): string
    {
        return self::$cache[$this->name] ??= file_get_contents(resource_path("icons/{$this->name}.svg"));
    }

    public function render(): View
    {
        return view('components.icon');
    }
}
