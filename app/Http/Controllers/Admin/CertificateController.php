<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CertificateRequest;
use App\Models\Certificate;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function __construct(private readonly ImageUploadService $images) {}

    public function index(): View
    {
        return view('admin.certificates.index', ['certificates' => Certificate::latestFirst()->get()]);
    }

    public function create(): View
    {
        return view('admin.certificates.form', ['certificate' => new Certificate]);
    }

    public function store(CertificateRequest $request): RedirectResponse
    {
        $this->save(new Certificate, $request);

        return redirect()->route('admin.certificates.index')->with('toast', 'Certificate added.');
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.form', ['certificate' => $certificate]);
    }

    public function update(CertificateRequest $request, Certificate $certificate): RedirectResponse
    {
        $this->save($certificate, $request);

        return redirect()->route('admin.certificates.index')->with('toast', 'Certificate saved.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('toast', 'Certificate deleted.');
    }

    private function save(Certificate $certificate, CertificateRequest $request): void
    {
        $certificate->fill($request->safe()->except(['file', 'image']));

        if ($request->hasFile('file')) {
            $certificate->file_path = $request->file('file')->store('documents', 'public');
        }

        if ($request->hasFile('image')) {
            $certificate->image_path = $this->images->store($request->file('image'), 'certificate')->path;
        }

        $certificate->save();
    }
}
