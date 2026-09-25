<?php

use App\Enums\ExperienceType;
use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\SeoSetting;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    actingAsAdmin();
});

it('shows the dashboard with counts', function () {
    ContactMessage::factory()->count(2)->create();
    ContactMessage::factory()->read()->create();

    $this->get(route('admin.dashboard'))->assertOk()->assertSee('Unread messages')->assertViewHas('unreadCount', 2);
});

it('updates the profile and replaces the photo', function () {
    $this->put(route('admin.profile.update'), [
        'name' => 'Muhammad Nafi Anzalulrahman',
        'nickname' => 'Key',
        'headline' => 'Frontend Developer',
        'open_to_work' => '1',
        'photo' => UploadedFile::fake()->image('me.jpg', 1000, 1000),
    ])->assertRedirect()->assertSessionHas('toast');

    $profile = Profile::sole();
    $firstPhoto = $profile->photo_path;
    expect($profile->open_to_work)->toBeTrue();

    $this->put(route('admin.profile.update'), [
        'name' => 'Muhammad Nafi Anzalulrahman',
        'headline' => 'Frontend Developer',
        'photo' => UploadedFile::fake()->image('me2.jpg', 1000, 1000),
    ]);

    expect(Profile::count())->toBe(1);
    Storage::disk('public')->assertMissing($firstPhoto);
    Storage::disk('public')->assertExists(Profile::sole()->photo_path);
});

it('updates seo settings', function () {
    $this->get(route('admin.seo.edit'))->assertOk();

    $this->put(route('admin.seo.update'), [
        'meta_title' => 'Key — Frontend Developer',
        'meta_description' => 'Portfolio',
        'og_image' => UploadedFile::fake()->image('og.png', 1600, 900),
    ])->assertSessionHasNoErrors();

    [$width, $height] = getimagesizefromstring(Storage::disk('public')->get(SeoSetting::sole()->og_image_path));
    expect([$width, $height])->toBe([1200, 630]);
});

it('manages experiences', function () {
    $this->get(route('admin.experiences.create'))->assertOk();

    $this->post(route('admin.experiences.store'), [
        'position' => 'Teaching Assistant',
        'organization' => 'Bengkel Koding',
        'type' => 'assistant',
        'started_at' => '2024-09-01',
        'ended_at' => '',
    ])->assertRedirect(route('admin.experiences.index'));

    $experience = Experience::sole();
    expect($experience->type)->toBe(ExperienceType::Assistant)->and($experience->isCurrent())->toBeTrue();

    $this->put(route('admin.experiences.update', $experience), [
        'position' => 'Teaching Assistant',
        'organization' => 'Bengkel Koding',
        'type' => 'assistant',
        'started_at' => '2024-09-01',
        'ended_at' => '2024-01-01',
    ])->assertSessionHasErrors('ended_at');

    $this->get(route('admin.experiences.index'))->assertOk()->assertSee('Teaching Assistant');
    $this->delete(route('admin.experiences.destroy', $experience))->assertRedirect();
    expect(Experience::count())->toBe(0);
});

it('manages skills', function () {
    $this->post(route('admin.skills.store'), ['name' => 'Laravel', 'category' => 'Backend'])->assertRedirect();
    $this->post(route('admin.skills.store'), ['name' => 'Laravel', 'category' => 'Backend'])->assertSessionHasErrors('name');

    $skill = Skill::sole();
    $this->get(route('admin.skills.edit', $skill))->assertOk();
    $this->put(route('admin.skills.update', $skill), ['name' => 'Laravel', 'category' => 'Framework'])->assertSessionHasNoErrors();
    expect($skill->refresh()->category)->toBe('Framework');

    $this->delete(route('admin.skills.destroy', $skill));
    expect(Skill::count())->toBe(0);
});

it('manages certificates with a pdf and image', function () {
    $this->post(route('admin.certificates.store'), [
        'title' => 'AWS Cloud Practitioner',
        'issuer' => 'Amazon',
        'issued_at' => '2025-03-01',
        'file' => UploadedFile::fake()->create('cert.pdf', 50, 'application/pdf'),
        'image' => UploadedFile::fake()->image('cert.jpg', 1200, 900),
    ])->assertRedirect(route('admin.certificates.index'));

    $certificate = Certificate::sole();
    Storage::disk('public')->assertExists([$certificate->file_path, $certificate->image_path]);

    $this->get(route('admin.certificates.index'))->assertOk()->assertSee('AWS Cloud Practitioner');
    $this->delete(route('admin.certificates.destroy', $certificate));

    Storage::disk('public')->assertMissing([$certificate->file_path, $certificate->image_path]);
});

it('manages social links', function () {
    $this->post(route('admin.social-links.store'), ['platform' => 'GitHub', 'url' => 'not a url'])->assertSessionHasErrors('url');
    $this->post(route('admin.social-links.store'), ['platform' => 'GitHub', 'url' => 'https://github.com/key'])->assertRedirect();

    $link = SocialLink::sole();
    $this->put(route('admin.social-links.update', $link), ['platform' => 'GitHub', 'url' => 'https://github.com/keyanffz'])->assertRedirect();
    expect($link->refresh()->url)->toBe('https://github.com/keyanffz');

    $this->patchJson(route('admin.reorder', 'social-links'), ['ids' => [$link->id]])->assertOk();
});

it('reads, re-flags and deletes contact messages', function () {
    $message = ContactMessage::factory()->create(['message' => 'Hello there, I have a project.']);

    $this->get(route('admin.messages.index', ['filter' => 'unread']))->assertOk()->assertSee('Hello there');

    $this->get(route('admin.messages.show', $message))->assertOk()->assertSee('Hello there');
    expect($message->refresh()->isRead())->toBeTrue();

    $this->patch(route('admin.messages.update', $message), ['read' => '0'])->assertRedirect(route('admin.messages.index'));
    expect($message->refresh()->isRead())->toBeFalse();

    $this->delete(route('admin.messages.destroy', $message))->assertRedirect();
    expect(ContactMessage::count())->toBe(0);
});
