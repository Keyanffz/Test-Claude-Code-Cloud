<?php

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;

beforeEach(function () {
    Profile::create(['name' => 'Muhammad Nafi Anzalulrahman', 'nickname' => 'Key', 'headline' => 'Frontend Developer & Student']);
});

it('renders the home page from the database', function () {
    Project::factory()->featured()->create(['title' => 'Pivactive']);
    Experience::factory()->create(['position' => 'Teaching Assistant']);
    Skill::factory()->create(['name' => 'Laravel']);

    $this->get('/')
        ->assertOk()
        ->assertSee('Key')
        ->assertSee('Pivactive')
        ->assertSee('Teaching Assistant')
        ->assertSee('Laravel')
        ->assertSee('application/ld+json', false);
});

it('works on a fresh install with no content', function () {
    Profile::query()->delete();

    $this->get('/')->assertOk();
    $this->get('/projects')->assertOk();
});

it('hides unpublished projects everywhere', function () {
    Project::factory()->featured()->create(['title' => 'Public One', 'slug' => 'public-one']);
    Project::factory()->featured()->unpublished()->create(['title' => 'Secret Draft', 'slug' => 'secret-draft']);

    $this->get('/')->assertSee('Public One')->assertDontSee('Secret Draft');
    $this->get('/projects')->assertSee('Public One')->assertDontSee('Secret Draft');
    $this->get('/projects/public-one')->assertOk();
    $this->get('/projects/secret-draft')->assertNotFound();
    $this->get('/sitemap.xml')->assertSee('public-one')->assertDontSee('secret-draft');
});

it('only features featured projects on the home page', function () {
    Project::factory()->featured()->create(['title' => 'Featured Work']);
    Project::factory()->create(['title' => 'Archive Work']);

    $this->get('/')->assertSee('Featured Work')->assertDontSee('Archive Work');
    $this->get('/projects')->assertSee('Archive Work');
});

it('filters projects by tech stack', function () {
    Project::factory()->create(['title' => 'Flutter App', 'tech_stack' => ['Flutter']]);
    Project::factory()->create(['title' => 'Laravel Site', 'tech_stack' => ['Laravel']]);

    $this->get('/projects?stack=flutter')->assertOk()->assertSee('Flutter App')->assertDontSee('Laravel Site');
    $this->get('/projects?stack=unknown')->assertSee('Flutter App')->assertSee('Laravel Site');
});

it('shows project details with markdown and neighbours', function () {
    Project::factory()->create(['title' => 'First', 'slug' => 'first', 'sort_order' => 1]);
    Project::factory()->create(['title' => 'Second', 'slug' => 'second', 'sort_order' => 2, 'description' => "## Approach\n\n**Bold** move"]);
    Project::factory()->create(['title' => 'Third', 'slug' => 'third', 'sort_order' => 3]);

    $this->get('/projects/second')
        ->assertOk()
        ->assertSee('<strong>Bold</strong>', false)
        ->assertSee('02 / 03')
        ->assertSee(route('projects.show', 'first'))
        ->assertSee(route('projects.show', 'third'))
        ->assertSee('<meta property="og:title" content="Second', false);
});

it('hides the certificates section when there are none', function () {
    $this->get('/')->assertDontSee('id="certificates"', false);

    Certificate::factory()->create(['title' => 'Cloud Practitioner']);

    $this->get('/')->assertSee('Cloud Practitioner');
});

it('serves a custom 404 page', function () {
    $this->get('/does-not-exist')->assertNotFound()->assertSee('This page is not in the index.');
});

it('refreshes cached pages after an admin change', function () {
    $project = Project::factory()->featured()->create(['title' => 'Before Rename']);
    $this->get('/')->assertSee('Before Rename');

    $project->update(['title' => 'After Rename']);

    $this->get('/')->assertSee('After Rename')->assertDontSee('Before Rename');
});

it('refreshes cached order after a reorder', function () {
    [$a, $b] = Project::factory()->count(2)->sequence(['title' => 'Alpha'], ['title' => 'Beta'])->create();
    $this->get('/projects')->assertSeeInOrder(['Alpha', 'Beta']);

    Project::saveOrder([$b->id, $a->id]);

    $this->get('/projects')->assertSeeInOrder(['Beta', 'Alpha']);
});

it('publishes robots.txt and a sitemap', function () {
    $this->get('/robots.txt')->assertOk()->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml')->assertSee('<urlset', false);
});

it('keeps admin pages out of search engines in production', function () {
    app()->detectEnvironment(fn () => 'production');

    $this->get('/robots.txt')->assertSee('Disallow: /admin')->assertSee('Sitemap: '.route('sitemap'));
});
