<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReorderRequest;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ReorderController extends Controller
{
    /** @var array<string, class-string<Model>> */
    public const SORTABLE = [
        'projects' => Project::class,
        'experiences' => Experience::class,
        'skills' => Skill::class,
        'social-links' => SocialLink::class,
    ];

    public function __invoke(ReorderRequest $request, string $sortable): JsonResponse
    {
        self::SORTABLE[$sortable]::saveOrder($request->validated('ids'));

        return response()->json(['message' => 'Order saved.']);
    }
}
