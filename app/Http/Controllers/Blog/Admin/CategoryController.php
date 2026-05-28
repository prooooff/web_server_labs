<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;


class CategoryController extends BaseController
{
    public function index()
    {
        $paginator = BlogCategory::orderBy('id', 'desc')->paginate(5);
        return $paginator;
    }


    public function store(BlogCategoryCreateRequest $request)
    {
        // В метод store() додаємо код:
        $data = $request->input(); //отримаємо масив даних, які надійшли з форми

        if (empty($data['slug'])) { //якщо псевдонім порожній
            $data['slug'] = Str::slug($data['title']); //генеруємо псевдонім
        }

        // створюємо об'єкт і додаємо в БД
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'item' => $item // Повертаємо створений об'єкт категорії
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }


    public function update(BlogCategoryUpdateRequest $request, string $id)
    {
        $item = BlogCategory::find($id);

        if (empty($item)) {
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
