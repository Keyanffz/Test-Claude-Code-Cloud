<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use App\Models\Skill;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::ordered()->withCount('images')->get(),
        ]);
    }

    public function create(): View
    {
        return $this->form(new Project(['is_published' => false, 'year' => now()->year]));
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = DB::transaction(function () use ($request) {
            $project = new Project($request->projectAttributes());
            $this->saveUploads($project, $request);

            return $project;
        });

        return redirect()->route('admin.projects.edit', $project)->with('toast', 'Project created.');
    }

    public function edit(Project $project): View
    {
        return $this->form($project->load('images'));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        DB::transaction(function () use ($request, $project) {
            $project->fill($request->projectAttributes());
            $this->saveUploads($project, $request);

            $alts = $request->validated('image_alts', []);
            $project->images()->whereKey(array_keys($alts))->get()
                ->each(fn ($image) => $image->update(['alt' => $alts[$image->id]]));
        });

        return redirect()->route('admin.projects.edit', $project)->with('toast', 'Project saved.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('toast', "“{$project->title}” deleted.");
    }

    private function form(Project $project): View
    {
        return view('admin.projects.form', [
            'project' => $project,
            'techSuggestions' => Skill::ordered()->pluck('name'),
        ]);
    }

    private function saveUploads(Project $project, ProjectRequest $request): void
    {
        if ($request->hasFile('thumbnail')) {
            $project->thumbnail_path = $this->images->store($request->file('thumbnail'), 'project_thumbnail')->path;
        }

        $project->save();

        $position = (int) $project->images()->max('sort_order');
        foreach ($request->file('gallery', []) as $file) {
            $stored = $this->images->store($file, 'project_gallery');
            $project->images()->create([
                'path' => $stored->path,
                'width' => $stored->width,
                'height' => $stored->height,
                'alt' => $project->title,
                'sort_order' => ++$position,
            ]);
        }
    }
}
