<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkillRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        return view('admin.skills.index', ['skills' => Skill::ordered()->get()]);
    }

    public function create(): View
    {
        return $this->form(new Skill);
    }

    public function store(SkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return redirect()->route('admin.skills.index')->with('toast', 'Skill added.');
    }

    public function edit(Skill $skill): View
    {
        return $this->form($skill);
    }

    public function update(SkillRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        return redirect()->route('admin.skills.index')->with('toast', 'Skill saved.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('toast', "“{$skill->name}” deleted.");
    }

    private function form(Skill $skill): View
    {
        return view('admin.skills.form', [
            'skill' => $skill,
            'categories' => Skill::query()->distinct()->orderBy('category')->pluck('category'),
        ]);
    }
}
