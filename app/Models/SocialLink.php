<?php

namespace App\Models;

use App\Models\Concerns\FlushesPortfolioCache;
use App\Models\Concerns\Sortable;
use Database\Factories\SocialLinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    /** @use HasFactory<SocialLinkFactory> */
    use FlushesPortfolioCache, HasFactory, Sortable;

    protected $fillable = ['platform', 'url', 'sort_order'];
}
