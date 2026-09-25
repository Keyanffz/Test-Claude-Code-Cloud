<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Concerns\ValidatesUploads;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    use ValidatesUploads;

    public const MAX_GALLERY_IMAGES = 12;

    public function rules(): array
    {
        $project = $this->route('project');

        return [
            'title' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'alpha_dash:ascii', 'max:140', Rule::unique('projects')->ignore($project)],
            'summary' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:20000'],
            'role' => ['nullable', 'string', 'max:120'],
            'tech_stack' => ['array', 'max:12'],
            'tech_stack.*' => ['string', 'max:40', 'distinct:ignore_case'],
            'live_url' => ['nullable', 'url:http,https', 'max:255'],
            'repo_url' => ['nullable', 'url:http,https', 'max:255'],
            'year' => ['nullable', 'integer', 'between:2000,'.(now()->year + 1)],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'thumbnail' => ['nullable', $this->imageRule()],
            'gallery' => ['array', 'max:'.self::MAX_GALLERY_IMAGES],
            'gallery.*' => [$this->imageRule()],
            'image_alts' => ['array'],
            'image_alts.*' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function attributes(): array
    {
        return [
            'tech_stack.*' => 'technology',
            'gallery.*' => 'gallery image',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('title')),
            'tech_stack' => $this->input('tech_stack', []),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function projectAttributes(): array
    {
        return $this->safe()->except(['thumbnail', 'gallery', 'image_alts']);
    }
}
