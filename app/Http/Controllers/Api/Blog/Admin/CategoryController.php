<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Support\Str;

// Зверху після use App\Models\BlogCategory; додаємо:


class CategoryController extends BaseController
{

    public function __construct(private BlogCategoryRepository $blogCategoryRepository)
    {
        //parent::__construct();
    }

    public function index()
    {
        // В методі index() коментуємо рядок: $paginator = BlogCategory::orderBy('id', 'desc')->paginate(5);
        // додаємо рядок
        // $paginator = BlogCategory::orderBy('id', 'desc')->paginate(5);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);

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
        // Замінюємо частину коду метода update(): BlogCategory::find($id); на $this->blogCategoryRepository->getEdit($id);
        $item = $this->blogCategoryRepository->getEdit($id);

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
