<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesUploads;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    use ValidatesUploads;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'nickname' => ['nullable', 'string', 'max:40'],
            'headline' => ['required', 'string', 'max:160'],
            'short_bio' => ['nullable', 'string', 'max:500'],
            'long_bio' => ['nullable', 'string', 'max:10000'],
            'location' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:255'],
            'open_to_work' => ['boolean'],
            'photo' => ['nullable', $this->imageRule()],
            'cv' => ['nullable', $this->pdfRule()],
            'remove_cv' => ['boolean'],
        ];
    }
}
