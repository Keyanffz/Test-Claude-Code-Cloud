<?php

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

it('redirects guests away from the admin area', function (string $uri) {
    $this->get($uri)->assertRedirect(route('admin.login'));
})->with(['/admin', '/admin/projects', '/admin/profile/edit', '/admin/messages', '/admin/skills', '/admin/seo/edit']);

it('does not expose a registration page', function () {
    $this->get('/register')->assertNotFound();
    $this->get('/admin/register')->assertNotFound();
});

it('shows the login form', function () {
    $this->get(route('admin.login'))->assertOk()->assertSee('Sign in');
});

it('signs in with valid credentials', function () {
    $user = User::factory()->create(['password' => 'correct-horse-battery']);

    $this->post(route('admin.login.store'), [
        'email' => $user->email,
        'password' => 'correct-horse-battery',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('rejects a wrong password', function () {
    $user = User::factory()->create();

    $this->from(route('admin.login'))
        ->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'nope'])
        ->assertRedirect(route('admin.login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('locks the login after five failed attempts', function () {
    $user = User::factory()->create(['password' => 'correct-horse-battery']);

    foreach (range(1, 5) as $attempt) {
        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'wrong']);
    }

    $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'correct-horse-battery'])
        ->assertSessionHasErrors(['email' => __('auth.throttle', [
            'seconds' => RateLimiter::availableIn(strtolower($user->email).'|127.0.0.1'),
            'minutes' => 1,
        ])]);

    $this->assertGuest();
});

it('redirects signed-in admins away from the login page', function () {
    actingAsAdmin()->get(route('admin.login'))->assertRedirect(route('admin.dashboard'));
});

it('signs out', function () {
    actingAsAdmin()->post(route('admin.logout'))->assertRedirect(route('admin.login'));

    $this->assertGuest();
});

it('creates an admin from the console', function () {
    $this->artisan('admin:create', [
        '--name' => 'Key',
        '--email' => 'key@example.com',
        '--password' => 'a-long-enough-password',
    ])->assertSuccessful();

    expect(User::where('email', 'key@example.com')->exists())->toBeTrue();
});

it('refuses a weak password from the console', function () {
    $this->artisan('admin:create', [
        '--name' => 'Key',
        '--email' => 'key@example.com',
        '--password' => 'short',
    ])->assertFailed();

    expect(User::count())->toBe(0);
});
