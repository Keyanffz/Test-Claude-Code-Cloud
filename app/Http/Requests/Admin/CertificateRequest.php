<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesUploads;
use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
{
    use ValidatesUploads;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:160'],
            'issuer' => ['required', 'string', 'max:120'],
            'issued_at' => ['required', 'date'],
            'url' => ['nullable', 'url:http,https', 'max:255'],
            'file' => ['nullable', $this->pdfRule()],
            'image' => ['nullable', $this->imageRule()],
        ];
    }
}
