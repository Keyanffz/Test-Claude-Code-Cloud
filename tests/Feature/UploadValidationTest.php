<?php

use App\Models\Profile;
use App\Models\Project;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    actingAsAdmin();
});

it('rejects files that are not images', function (UploadedFile $file) {
    $this->post(route('admin.projects.store'), [
        'title' => 'Project',
        'summary' => 'Summary',
        'thumbnail' => $file,
    ])->assertSessionHasErrors('thumbnail');

    expect(Project::count())->toBe(0);
})->with([
    'pdf' => fn () => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
    'svg' => fn () => UploadedFile::fake()->create('logo.svg', 10, 'image/svg+xml'),
    'gif' => fn () => UploadedFile::fake()->image('anim.gif'),
    'php disguised as jpg' => fn () => UploadedFile::fake()->createWithContent('shell.jpg', '<?php echo 1;'),
]);

it('rejects images over the size limit', function () {
    $this->post(route('admin.projects.store'), [
        'title' => 'Project',
        'summary' => 'Summary',
        'thumbnail' => UploadedFile::fake()->image('huge.jpg')->size(config('images.max_upload_kb') + 1),
    ])->assertSessionHasErrors('thumbnail');
});

it('validates every gallery image', function () {
    $this->post(route('admin.projects.store'), [
        'title' => 'Project',
        'summary' => 'Summary',
        'gallery' => [UploadedFile::fake()->image('ok.jpg'), UploadedFile::fake()->create('bad.txt', 1, 'text/plain')],
    ])->assertSessionHasErrors('gallery.1');
});

it('accepts a pdf cv and rejects other document types', function () {
    $this->put(route('admin.profile.update'), [
        'name' => 'Key',
        'headline' => 'Developer',
        'cv' => UploadedFile::fake()->create('cv.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
    ])->assertSessionHasErrors('cv');

    $this->put(route('admin.profile.update'), [
        'name' => 'Key',
        'headline' => 'Developer',
        'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
    ])->assertSessionHasNoErrors();

    Storage::disk('public')->assertExists(Profile::sole()->cv_path);
});
