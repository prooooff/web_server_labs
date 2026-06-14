<?php

namespace App\Http\Resources\Api\Blog\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Трансформація ресурсу в масив.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'content_raw'    => $this->content_raw,
            'is_published'   => (bool) $this->is_published,

            // Форматуємо дату для зручності фронтенду
            'date_published' => $this->published_at ? \Carbon\Carbon::parse($this->published_at)->format('Y-m-d H:i:s') : null,

            // Передаємо id зв'язаних сутностей
            'user_id'        => $this->user_id,
            'category_id'    => $this->category_id,

            // Плоскі ключі для таблиці
            'category_title' => $this->category?->title,
            'author_name'    => $this->user?->name,
        ];
    }
}
