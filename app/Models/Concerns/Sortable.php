<?php

namespace App\Models\Concerns;

use App\Support\PortfolioCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait Sortable
{
    protected static function bootSortable(): void
    {
        static::creating(function (self $model) {
            $model->sort_order ??= (static::max('sort_order') ?? 0) + 1;
        });
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @param  array<int, int>  $ids  Ids in their new display order.
     */
    public static function reorder(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            foreach (array_values($ids) as $position => $id) {
                static::whereKey($id)->update(['sort_order' => $position + 1]);
            }
        });

        // Bulk updates bypass model events, so the cache is flushed by hand.
        PortfolioCache::flush();
    }
}
