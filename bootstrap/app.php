<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // A visitor who hits the contact limit should see a message in the form, not a bare 429 page.
        $exceptions->render(function (ThrottleRequestsException $exception, Request $request) {
            if ($request->routeIs('contact.store') && ! $request->expectsJson()) {
                return redirect()->to(route('home').'#contact')
                    ->withInput($request->except('_token'))
                    ->withErrors(['message' => 'You have sent several messages in a short time. Please wait a few minutes and try again.']);
            }
        });
    })->create();
