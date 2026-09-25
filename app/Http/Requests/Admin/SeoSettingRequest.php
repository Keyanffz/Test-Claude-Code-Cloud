<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesUploads;
use Illuminate\Foundation\Http\FormRequest;

class SeoSettingRequest extends FormRequest
{
    use ValidatesUploads;

    public function rules(): array
    {
        return [
            'meta_title' => ['required', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'og_image' => ['nullable', $this->imageRule()],
        ];
    }
}
