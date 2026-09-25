<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\HasStoredFiles;
use App\Models\Concerns\Sortable;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use FlushesPortfolioCache, HasFactory, HasStoredFiles, Sortable;

    protected $fillable = [
        'title', 'slug', 'summary', 'description', 'role', 'tech_stack', 'thumbnail_path',
        'live_url', 'repo_url', 'year', 'is_featured', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'year' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        // Gallery rows are removed through Eloquent (not the FK cascade) so their files go too.
        static::deleting(fn (self $project) => $project->images->each->delete());
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function storedFileAttributes(): array
    {
        return ['thumbnail_path'];
    }
}
