<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SocialLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'platform' => ['required', 'string', 'max:40'],
            'url' => ['required', 'url:http,https,mailto', 'max:255'],
        ];
    }
}
