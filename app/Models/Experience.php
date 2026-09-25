<?php

namespace App\Models;

use App\Enums\ExperienceType;
use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Sortable;
use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /** @use HasFactory<ExperienceFactory> */
    use FlushesPortfolioCache, HasFactory, Sortable;

    protected $fillable = ['position', 'organization', 'type', 'started_at', 'ended_at', 'description', 'sort_order'];

    protected function casts(): array
    {
        return [
            'type' => ExperienceType::class,
            'started_at' => 'date',
            'ended_at' => 'date',
        ];
    }

    public function isCurrent(): bool
    {
        return $this->ended_at === null;
    }

    public function period(): string
    {
        $end = $this->ended_at?->format('M Y') ?? 'Present';

        return $this->started_at->format('M Y').' — '.$end;
    }
}
