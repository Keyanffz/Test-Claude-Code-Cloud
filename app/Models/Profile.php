<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\HasStoredFiles;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use FlushesPortfolioCache, HasStoredFiles;

    protected $fillable = [
        'name', 'nickname', 'headline', 'short_bio', 'long_bio',
        'photo_path', 'location', 'email', 'cv_path', 'open_to_work',
    ];

    protected function casts(): array
    {
        return ['open_to_work' => 'boolean'];
    }

    public static function current(): self
    {
        return static::query()->firstOrNew();
    }

    public function displayName(): string
    {
        return $this->nickname ?: $this->name;
    }

    protected function storedFileAttributes(): array
    {
        return ['photo_path', 'cv_path'];
    }
}
