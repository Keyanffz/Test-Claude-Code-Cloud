<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Support\Portfolio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request, Portfolio $portfolio): View
    {
        $projects = $portfolio->projects();
        $technologies = $portfolio->technologies();

        $stack = $technologies->first(fn (string $technology) => strcasecmp($technology, (string) $request->query('stack')) === 0);

        return view('site.projects.index', [
            'projects' => $stack
                ? $projects->filter(fn ($project) => in_array($stack, $project->tech_stack, true))->values()
                : $projects,
            'technologies' => $technologies,
            'activeStack' => $stack,
            'total' => $projects->count(),
        ]);
    }

    public function show(Portfolio $portfolio, string $slug): View
    {
        $project = $portfolio->project($slug) ?? abort(404);

        $projects = $portfolio->projects()->values();
        $total = $projects->count();
        $position = $projects->search(fn ($item) => $item->id === $project->id);

        // Wraps around so the last project still leads somewhere.
        $hasSiblings = $total > 1;

        return view('site.projects.show', [
            'project' => $project,
            'position' => $position + 1,
            'total' => $total,
            'previous' => $hasSiblings ? $projects->get(($position - 1 + $total) % $total) : null,
            'next' => $hasSiblings ? $projects->get(($position + 1) % $total) : null,
        ]);
    }
}
