<?php

namespace App\Http\Controllers\Api\Blog;

use App\Models\BlogPost;
use App\Http\Resources\PostCollection;
use App\Http\Resources\Api\Blog\PostResource;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Завантажуємо активні статті з їх категоріями та авторами
        $items = BlogPost::with(['category', 'user'])
            ->where('is_published', 1)
            ->get();

        // Повертаємо через Resource Collection (якщо він у вас вже створений)
        return new PostCollection($items);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = BlogPost::with(['category', 'user'])
            ->where('is_published', 1)
            ->findOrFail($id);

        return new PostResource($item);
    }
}
