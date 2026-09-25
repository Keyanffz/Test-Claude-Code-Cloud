<?php

use App\Models\ContactMessage;
use App\Models\Profile;

beforeEach(function () {
    Profile::create(['name' => 'Key', 'headline' => 'Developer']);
});

function contactData(array $overrides = []): array
{
    return [
        'name' => 'Recruiter',
        'email' => 'recruiter@example.com',
        'message' => 'We would like to talk about a frontend role.',
        ...$overrides,
    ];
}

it('stores a message and confirms it', function () {
    $this->post(route('contact.store'), contactData())
        ->assertRedirect(route('home').'#contact')
        ->assertSessionHas('contact_sent');

    expect(ContactMessage::sole())
        ->email->toBe('recruiter@example.com')
        ->read_at->toBeNull();

    $this->followingRedirects()->get('/')->assertOk();
});

it('validates the message', function () {
    $this->post(route('contact.store'), contactData(['email' => 'nope', 'message' => 'short']))
        ->assertRedirect(route('home').'#contact')
        ->assertSessionHasErrors(['email', 'message']);

    expect(ContactMessage::count())->toBe(0);
});

it('silently drops submissions that fill the honeypot', function () {
    $this->post(route('contact.store'), contactData(['website' => 'https://spam.example']))
        ->assertRedirect(route('home').'#contact')
        ->assertSessionHas('contact_sent');

    expect(ContactMessage::count())->toBe(0);
});

it('rate limits repeated submissions', function () {
    foreach (range(1, 3) as $attempt) {
        $this->post(route('contact.store'), contactData())->assertSessionHasNoErrors();
    }

    $this->post(route('contact.store'), contactData())
        ->assertRedirect(route('home').'#contact')
        ->assertSessionHasErrors('message');

    expect(ContactMessage::count())->toBe(3);
});

it('returns 429 to json clients over the limit', function () {
    foreach (range(1, 3) as $attempt) {
        $this->postJson(route('contact.store'), contactData());
    }

    $this->postJson(route('contact.store'), contactData())->assertTooManyRequests();
});
