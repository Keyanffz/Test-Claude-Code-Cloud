<?php

namespace App\Models\Concerns;

use App\Services\ImageUploadService;

/**
 * Removes files from disk when the column pointing at them changes or the row is
 * deleted, so controllers never have to remember cleanup.
 */
trait HasStoredFiles
{
    /**
     * @return array<int, string>
     */
    abstract protected function storedFileAttributes(): array;

    protected static function bootHasStoredFiles(): void
    {
        static::updated(function (self $model) {
            foreach ($model->storedFileAttributes() as $attribute) {
                if ($model->wasChanged($attribute)) {
                    app(ImageUploadService::class)->delete($model->getOriginal($attribute));
                }
            }
        });

        static::deleted(function (self $model) {
            foreach ($model->storedFileAttributes() as $attribute) {
                app(ImageUploadService::class)->delete($model->getAttribute($attribute));
            }
        });
    }
}
