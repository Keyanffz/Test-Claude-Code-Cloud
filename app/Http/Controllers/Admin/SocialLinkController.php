<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SocialLinkRequest;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(): View
    {
        return view('admin.social-links.index', ['socialLinks' => SocialLink::ordered()->get()]);
    }

    public function create(): View
    {
        return view('admin.social-links.form', ['socialLink' => new SocialLink]);
    }

    public function store(SocialLinkRequest $request): RedirectResponse
    {
        SocialLink::create($request->validated());

        return redirect()->route('admin.social-links.index')->with('toast', 'Link added.');
    }

    public function edit(SocialLink $socialLink): View
    {
        return view('admin.social-links.form', ['socialLink' => $socialLink]);
    }

    public function update(SocialLinkRequest $request, SocialLink $socialLink): RedirectResponse
    {
        $socialLink->update($request->validated());

        return redirect()->route('admin.social-links.index')->with('toast', 'Link saved.');
    }

    public function destroy(SocialLink $socialLink): RedirectResponse
    {
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')->with('toast', "{$socialLink->platform} link deleted.");
    }
}
