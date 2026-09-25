<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SkillRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:60', Rule::unique('skills')->ignore($this->route('skill'))],
            'category' => ['required', 'string', 'max:60'],
        ];
    }
}
