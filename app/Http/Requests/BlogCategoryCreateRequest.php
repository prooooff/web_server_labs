<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'parent_id' => $this->input('parent_id') ?? 0,
            'slug' => $this->input('slug') ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:5|max:200|unique:blog_categories',
            'slug' => 'nullable|max:200|unique:blog_categories',
            'description' => 'nullable|string|max:500|min:3',
            'parent_id' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'Категорія з такою назвою вже існує',
            'slug.unique' => 'Категорія з таким slug вже існує',
        ];
    }
}
