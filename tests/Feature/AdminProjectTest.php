<?php

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    actingAsAdmin();
});

function validProjectData(array $overrides = []): array
{
    return [
        'title' => 'Pivactive',
        'slug' => '',
        'summary' => 'Sports facility booking.',
        'description' => '## Hello',
        'role' => 'Frontend Developer',
        'tech_stack' => ['Next.js', 'Laravel'],
        'year' => 2025,
        'is_published' => '1',
        'is_featured' => '0',
        ...$overrides,
    ];
}

it('lists projects', function () {
    Project::factory()->create(['title' => 'Listed Project']);

    $this->get(route('admin.projects.index'))->assertOk()->assertSee('Listed Project');
});

it('shows the create form', function () {
    $this->get(route('admin.projects.create'))->assertOk()->assertSee('New project');
});

it('creates a project and converts the thumbnail to webp', function () {
    $response = $this->post(route('admin.projects.store'), validProjectData([
        'thumbnail' => UploadedFile::fake()->image('cover.jpg', 2400, 1800),
        'gallery' => [UploadedFile::fake()->image('one.png', 1200, 800)],
    ]));

    $project = Project::sole();
    $response->assertRedirect(route('admin.projects.edit', $project))->assertSessionHas('toast');

    expect($project)
        ->slug->toBe('pivactive')
        ->tech_stack->toBe(['Next.js', 'Laravel'])
        ->is_published->toBeTrue()
        ->thumbnail_path->toEndWith('.webp');

    Storage::disk('public')->assertExists($project->thumbnail_path);
    Storage::disk('public')->assertExists(str_replace('.webp', '-480.webp', $project->thumbnail_path));

    [$width, $height] = getimagesizefromstring(Storage::disk('public')->get($project->thumbnail_path));
    expect([$width, $height])->toBe([1600, 1200]);

    $image = $project->images()->sole();
    expect([$image->width, $image->height])->toBe([1200, 800]);
    Storage::disk('public')->assertExists($image->path);
});

it('shows the edit form', function () {
    $project = Project::factory()->create();

    $this->get(route('admin.projects.edit', $project))->assertOk()->assertSee($project->title);
});

it('updates a project and removes the replaced thumbnail', function () {
    $this->post(route('admin.projects.store'), validProjectData([
        'thumbnail' => UploadedFile::fake()->image('old.jpg', 800, 600),
    ]));
    $project = Project::sole();
    $oldThumbnail = $project->thumbnail_path;

    $this->put(route('admin.projects.update', $project), validProjectData([
        'title' => 'Pivactive v2',
        'slug' => 'pivactive-v2',
        'thumbnail' => UploadedFile::fake()->image('new.jpg', 800, 600),
    ]))->assertRedirect(route('admin.projects.edit', 'pivactive-v2'));

    $project->refresh();
    expect($project->title)->toBe('Pivactive v2')
        ->and($project->thumbnail_path)->not->toBe($oldThumbnail);

    Storage::disk('public')->assertMissing($oldThumbnail);
    Storage::disk('public')->assertMissing(str_replace('.webp', '-480.webp', $oldThumbnail));
    Storage::disk('public')->assertExists($project->thumbnail_path);
});

it('rejects a duplicate slug', function () {
    Project::factory()->create(['slug' => 'taken']);

    $this->post(route('admin.projects.store'), validProjectData(['slug' => 'taken']))
        ->assertSessionHasErrors('slug');
});

it('deletes a project with its images and files', function () {
    $this->post(route('admin.projects.store'), validProjectData([
        'thumbnail' => UploadedFile::fake()->image('cover.jpg', 800, 600),
        'gallery' => [UploadedFile::fake()->image('one.jpg', 800, 600)],
    ]));
    $project = Project::sole();
    $files = [$project->thumbnail_path, $project->images()->sole()->path];

    $this->delete(route('admin.projects.destroy', $project))->assertRedirect(route('admin.projects.index'));

    expect(Project::count())->toBe(0)->and(ProjectImage::count())->toBe(0);
    foreach ($files as $file) {
        Storage::disk('public')->assertMissing($file);
    }
});

it('removes a single gallery image', function () {
    $this->post(route('admin.projects.store'), validProjectData([
        'gallery' => [UploadedFile::fake()->image('one.jpg', 800, 600)],
    ]));
    $project = Project::sole();
    $image = $project->images()->sole();

    $this->delete(route('admin.projects.images.destroy', [$project, $image]))->assertRedirect();

    expect(ProjectImage::count())->toBe(0);
    Storage::disk('public')->assertMissing($image->path);
});

it('does not delete an image through another project', function () {
    $owner = Project::factory()->create();
    $other = Project::factory()->create();
    $image = $owner->images()->create(['path' => 'x.webp', 'width' => 1, 'height' => 1]);

    $this->delete(route('admin.projects.images.destroy', [$other, $image]))->assertNotFound();
});

it('toggles visibility without a page reload', function () {
    $project = Project::factory()->create(['is_published' => true]);

    $this->patchJson(route('admin.projects.visibility', $project), ['field' => 'is_published', 'value' => false])
        ->assertOk()
        ->assertJson(['is_published' => false]);

    expect($project->refresh()->is_published)->toBeFalse();
});

it('only toggles whitelisted fields', function () {
    $project = Project::factory()->create();

    $this->patchJson(route('admin.projects.visibility', $project), ['field' => 'title', 'value' => true])
        ->assertUnprocessable();
});

it('saves a new order', function () {
    [$a, $b, $c] = Project::factory()->count(3)->create();

    $this->patchJson(route('admin.reorder', 'projects'), ['ids' => [$c->id, $a->id, $b->id]])->assertOk();

    expect(Project::ordered()->pluck('id')->all())->toBe([$c->id, $a->id, $b->id]);
});

it('refuses to reorder unknown resources', function () {
    $this->patchJson('/admin/users/reorder', ['ids' => [1]])->assertNotFound();
});

it('renders markdown previews without raw html', function () {
    $this->postJson(route('admin.markdown.preview'), ['markdown' => '**bold** <script>alert(1)</script>'])
        ->assertOk()
        ->assertJsonPath('html', fn (string $html) => str_contains($html, '<strong>bold</strong>') && ! str_contains($html, '<script>'));
});
