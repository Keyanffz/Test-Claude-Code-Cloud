<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectVisibilityRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectVisibilityController extends Controller
{
    public function __invoke(ProjectVisibilityRequest $request, Project $project): JsonResponse
    {
        $field = $request->validated('field');
        $value = $request->boolean('value');

        $project->update([$field => $value]);

        $message = match ($field) {
            'is_published' => $value ? 'is now live.' : 'is hidden from the site.',
            'is_featured' => $value ? 'is featured on the home page.' : 'is no longer featured.',
        };

        return response()->json(['message' => "“{$project->title}” {$message}", $field => $value]);
    }
}
