<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    // В метод rules() в масив return додаємо код:
    public function rules(): array
    {
        return [
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'string|max:500|min:3',
            'parent_id' => 'nullable|integer|exists:blog_categories,id',
        ];
    }
}
