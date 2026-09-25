<?php

namespace App\Models\Concerns;

use App\Support\PortfolioCache;

trait FlushesPortfolioCache
{
    protected static function bootFlushesPortfolioCache(): void
    {
        static::saved(fn () => PortfolioCache::flush());
        static::deleted(fn () => PortfolioCache::flush());
    }
}
