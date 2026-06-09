<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Models\BlogPost;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Repositories\BlogPostRepository;
use App\Repositories\BlogCategoryRepository;
use App\Http\Controllers\Api\Blog\BaseController;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository,
    ) {
    }

    /**
     * Список всіх статей
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();
        return response()->json($paginator->toArray());
    }

    /**
     * Створення статті (Лабораторна 11 + 12)
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item) {
            // Лаб 12: Тригер черги після створення
            $job = new BlogPostAfterCreateJob($item);
            dispatch($job);

            return response()->json([
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item
            ]);
        } {
        return response()->json(['message' => 'Помилка збереження'], 500);
    }
    }

    /**
     * Оновлення статті
     */
    public function update(BlogPostUpdateRequest $request, string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
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
            return response()->json(['message' => 'Помилка збереження'], 500);
        }
    }

    /**
     * Видалення статті (Лабораторна 11 + 12 із гарним JSON-респонсом)
     */
    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id); // софт деліт

        if ($result) {
            // Лаб 12: Надсилаємо задачу в чергу із затримкою 20 секунд
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);

            // Повертаємо зрозумілу відповідь замість порожнього []
            return response()->json([
                'success' => true,
                'message' => "Статтю з id=[{$id}] успішно видалено (Soft Delete)"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Помилка видалення, запис не знайдено чи вже видалено'
            ], 404);
        }
    }
}
