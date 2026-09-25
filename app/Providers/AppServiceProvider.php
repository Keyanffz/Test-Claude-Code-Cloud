<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Support\Portfolio;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ImageManager::class, fn () => ImageManager::gd());
        $this->app->scoped(Portfolio::class);
    }

    public function boot(): void
    {
        // Surfaces N+1 queries and silently dropped attributes while developing.
        Model::shouldBeStrict(! $this->app->isProduction());

        Paginator::defaultView('pagination::simple');
        Paginator::defaultSimpleView('pagination::simple');

        RateLimiter::for('contact', fn (Request $request) => [
            Limit::perMinute(3)->by($request->ip()),
            Limit::perDay(20)->by($request->ip()),
        ]);

        View::composer(['components.layout', 'site.*', 'partials.site-*'], function ($view) {
            $view->with(app(Portfolio::class)->site());
        });

        View::composer('components.admin.layout', function ($view) {
            $view->with('unreadMessages', ContactMessage::unread()->count());
        });
    }
}
