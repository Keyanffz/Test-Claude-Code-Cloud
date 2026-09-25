<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MarkdownPreviewController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectImageController;
use App\Http\Controllers\Admin\ProjectVisibilityController;
use App\Http\Controllers\Admin\ReorderController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SocialLinkController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::singleton('profile', ProfileController::class)->only(['edit', 'update']);
    Route::singleton('seo', SeoSettingController::class)->only(['edit', 'update']);

    Route::patch('{sortable}/reorder', ReorderController::class)
        ->whereIn('sortable', array_keys(ReorderController::SORTABLE))
        ->name('reorder');

    Route::resource('projects', ProjectController::class)->except('show');
    Route::patch('projects/{project}/visibility', ProjectVisibilityController::class)->name('projects.visibility');
    Route::delete('projects/{project}/images/{image}', [ProjectImageController::class, 'destroy'])
        ->scopeBindings()
        ->name('projects.images.destroy');

    Route::resource('experiences', ExperienceController::class)->except('show');
    Route::resource('skills', SkillController::class)->except('show');
    Route::resource('certificates', CertificateController::class)->except('show');
    Route::resource('social-links', SocialLinkController::class)->except('show');
    Route::resource('messages', ContactMessageController::class)->only(['index', 'show', 'update', 'destroy']);

    Route::post('markdown/preview', MarkdownPreviewController::class)->name('markdown.preview');
});
