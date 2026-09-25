<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageManager::class, fn () => ImageManager::gd());
    }

    public function boot(): void
    {
        // Surfaces N+1 queries and silently dropped attributes while developing.
        Model::shouldBeStrict(! $this->app->isProduction());

        RateLimiter::for('contact', fn (Request $request) => [
            Limit::perMinute(3)->by($request->ip()),
            Limit::perDay(20)->by($request->ip()),
        ]);
    }
}
