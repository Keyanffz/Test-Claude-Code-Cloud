<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Profile;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['profile' => Profile::current()]);
    }

    public function update(ProfileRequest $request, ImageUploadService $images): RedirectResponse
    {
        $profile = Profile::current();
        $profile->fill($request->safe()->except(['photo', 'cv', 'remove_cv']));

        if ($request->hasFile('photo')) {
            $profile->photo_path = $images->store($request->file('photo'), 'profile_photo')->path;
        }

        if ($request->hasFile('cv')) {
            $profile->cv_path = $request->file('cv')->store('documents', 'public');
        } elseif ($request->boolean('remove_cv')) {
            $profile->cv_path = null;
        }

        $profile->save();

        return back()->with('toast', 'Profile saved.');
    }
}
