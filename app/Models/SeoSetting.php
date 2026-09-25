<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\HasStoredFiles;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use FlushesPortfolioCache, HasStoredFiles;

    protected $fillable = ['meta_title', 'meta_description', 'og_image_path'];

    public static function current(): self
    {
        return static::query()->firstOrNew();
    }

    protected function storedFileAttributes(): array
    {
        return ['og_image_path'];
    }
}
