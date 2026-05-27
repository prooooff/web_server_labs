<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    public function index()
    {
        $paginator = BlogCategory::orderBy('id', 'desc')->paginate(5);
        return $paginator;
    }

    // Реалізація методу store з поверненням створеного об'єкта
    public function store(Request $request)
    {
        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $item = BlogCategory::create($data);

        if ($item) {
            return [
                'success' => 'Успішно збережено',
                'item' => $item
            ];
        } else {
            return ['msg' => 'Помилка збереження'];
        }
    }

    // Реалізація методу update з правильним API-респонсом для неіснуючих ID
    public function update(Request $request, string $id)
    {
        $item = BlogCategory::find($id);

        if (empty($item)) {
            // Повертаємо правильну JSON помилку 404 замість HTML сторінки
            return response()->json(['error' => "Запис id=[{$id}] не знайдено"], 404);
        }

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $result = $item->update($data);

        if ($result) {
            return [
                'success' => 'Успішно збережено',
                'item' => $item
            ];
        } else {
            return ['msg' => 'Помилка збереження'];
        }
    }
}
