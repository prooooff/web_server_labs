<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Models\BlogPost;
use App\Http\Requests\BlogPostCreateRequest;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Controllers\Api\Blog\BaseController;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository,
    ) {
    }

    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();
        return response()->json($paginator->toArray());
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input(); // отримаємо масив даних з форми

        $item = (new BlogPost())->create($data); // створюємо об'єкт і додаємо в БД

        if ($item) {
            return response()->json(['success' => 'Успішно збережено', 'data' => $item]);
        } else {
            return response()->json(['msg' => 'Помилка збереження'], 500);
        }
    }

    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $this->blogPostRepository->getEdit($id),
            ]);
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id); // софт деліт

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Статтю успішно видалено']);
        } else {
            return response()->json(['success' => false, 'message' => 'Помилка видалення'], 404);
        }
    }
}
