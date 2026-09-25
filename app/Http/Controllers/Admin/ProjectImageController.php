<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\RedirectResponse;

class ProjectImageController extends Controller
{
    public function destroy(Project $project, ProjectImage $image): RedirectResponse
    {
        $image->delete();

        return redirect()->route('admin.projects.edit', $project)->with('toast', 'Image removed.');
    }
}
