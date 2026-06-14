<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Resources\Api\Blog\Admin\PostResource;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    use DispatchesJobs;

    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogCategoryRepository $blogCategoryRepository
    ) {
    }

    public function index(Request $request)
    {
        // Перехоплюємо динамічні параметри, які надсилає нам Nuxt
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc');

        // Передаємо параметри у репозиторій
        $paginator = $this->blogPostRepository->getAllWithPaginate($perPage, $search, $sortBy, $sortDir);

        // Обгортаємо пагінацію в API Ресурс Дарини
        return PostResource::collection($paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if ($item) {
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);

            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item
            ];
        } else {
            return ['msg' => 'Помилка збереження'];
        }
    }

    /**
     * Display the specified resource (Реалізовано для зчитування даних перед редагуванням).
     */
    public function show(string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return response()->json(['message' => 'Запис не знайдено'], 404);
        }

        // Повертаємо через ресурс, щоб Nuxt отримав чистий об'єкт статті
        return new PostResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);

            return [
                'success' => true,
                'message' => "Статтю з id [{$id}] успішно видалено!"
            ];
        } else {
            return [
                'success' => false,
                'message' => "Помилка видалення або статтю вже було видалено"
            ];
        }
    }
}
