<?php

namespace App\Http\Requests\Admin;

use App\Enums\ExperienceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExperienceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'position' => ['required', 'string', 'max:120'],
            'organization' => ['required', 'string', 'max:160'],
            'type' => ['required', Rule::enum(ExperienceType::class)],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return ['ended_at.after_or_equal' => 'The end date cannot be before the start date.'];
    }
}
