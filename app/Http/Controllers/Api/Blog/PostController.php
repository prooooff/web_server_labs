<?php

namespace App\Http\Controllers\Api\Blog;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    // Отримати всі пости (GET)
    public function index()
    {
        return BlogPost::all();
    }

    // Створити новий пост (POST)
    public function store(Request $request)
    {
        $item = BlogPost::create($request->all());
        return response()->json($item, 201); // 201 означає "Створено"
    }

    // Отримати один конкретний пост за ID (GET)
    public function show(string $id)
    {
        // findOrFail автоматично видасть помилку 404, якщо такого ID немає
        return BlogPost::findOrFail($id);
    }

    // Оновити існуючий пост (PUT/PATCH)
    public function update(Request $request, string $id)
    {
        $item = BlogPost::findOrFail($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    // Видалити пост (DELETE)
    public function destroy(string $id)
    {
        $item = BlogPost::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Пост успішно видалено'], 200);
    }
}
