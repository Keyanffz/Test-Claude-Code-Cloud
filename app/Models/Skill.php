<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Sortable;
use Database\Factories\SkillFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /** @use HasFactory<SkillFactory> */
    use FlushesPortfolioCache, HasFactory, Sortable;

    protected $fillable = ['name', 'category', 'sort_order'];
}
