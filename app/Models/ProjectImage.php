<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\HasStoredFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    use FlushesPortfolioCache, HasStoredFiles;

    protected $fillable = ['path', 'alt', 'width', 'height', 'sort_order'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    protected function storedFileAttributes(): array
    {
        return ['path'];
    }
}
