<?php

namespace App\Support;

use Closure;
use Illuminate\Support\Facades\Cache;

/**
 * Public pages read through this cache. Instead of tracking every key (project slugs,
 * filters…), keys are namespaced by a version number and a flush just bumps it; stale
 * entries age out on their own.
 */
class PortfolioCache
{
    private const VERSION_KEY = 'portfolio:version';

    private const TTL_SECONDS = 60 * 60 * 24 * 7;

    public static function remember(string $key, Closure $callback): mixed
    {
        return Cache::remember(self::key($key), self::TTL_SECONDS, $callback);
    }

    public static function flush(): void
    {
        Cache::forever(self::VERSION_KEY, self::version() + 1);

        // Whatever Portfolio memoized earlier in this request is stale now too.
        app()->forgetInstance(Portfolio::class);
    }

    private static function key(string $key): string
    {
        return 'portfolio:v'.self::version().':'.$key;
    }

    private static function version(): int
    {
        return (int) Cache::get(self::VERSION_KEY, 1);
    }
}
