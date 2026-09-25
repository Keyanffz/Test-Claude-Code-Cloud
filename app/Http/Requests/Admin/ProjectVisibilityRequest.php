<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectVisibilityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'field' => ['required', 'in:is_published,is_featured'],
            'value' => ['required', 'boolean'],
        ];
    }
}
