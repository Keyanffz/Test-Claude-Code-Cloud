<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoSettingRequest;
use App\Models\SeoSetting;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeoSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.seo.edit', ['seo' => SeoSetting::current()]);
    }

    public function update(SeoSettingRequest $request, ImageUploadService $images): RedirectResponse
    {
        $seo = SeoSetting::current();
        $seo->fill($request->safe()->except('og_image'));

        if ($request->hasFile('og_image')) {
            $seo->og_image_path = $images->store($request->file('og_image'), 'og_image')->path;
        }

        $seo->save();

        return back()->with('toast', 'SEO settings saved.');
    }
}
