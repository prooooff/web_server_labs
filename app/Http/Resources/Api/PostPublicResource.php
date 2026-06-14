<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'content_html'   => $this->content_html,
            'content_raw'    => $this->content_raw, // Додано про всяк випадок, якщо content_html порожній
            'date_published' => $this->published_at ? \Carbon\Carbon::parse($this->published_at)->format('d.m.Y') : null,
            'category_title' => $this->category?->title,
            'author_name'    => $this->user?->name,
        ];
    }
}
