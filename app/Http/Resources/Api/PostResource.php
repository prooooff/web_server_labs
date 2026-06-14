<?php

namespace App\Http\Resources\Api; // <-- ЗМІНЕНО ТІЛЬКИ ЦЕЙ РЯДОК

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'content_raw'    => $this->content_raw,
            'is_published'   => (bool) $this->is_published,
            'date_published' => $this->published_at ? \Carbon\Carbon::parse($this->published_at)->format('Y-m-d H:i:s') : null,
            'user_id'        => $this->user_id,
            'category_id'    => $this->category_id,
            'category_title' => $this->category?->title,
            'author_name'    => $this->user?->name,
        ];
    }
}
