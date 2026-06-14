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
use App\Http\Resources\Api\PostResource;
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
        $perPage = $request->input('per_page');
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = $request->input('sort_dir', 'desc');

        $paginator = $this->blogPostRepository->getAllWithPaginate($perPage, $search, $sortBy, $sortDir);

        return PostResource::collection($paginator);
    }

    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item) {
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);

            return ['success' => true, 'message' => 'Успішно збережено', 'data' => $item];
        } else {
            return ['msg' => 'Помилка збереження'];
        }
    }

    public function show(string $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)) {
            return response()->json(['message' => 'Запис не знайдено'], 404);
        }

        return new PostResource($item);
    }

    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return ['success' => true, 'message' => 'Успішно збережено', 'data' => $item];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id);

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);
            return ['success' => true, 'message' => "Статтю з id [{$id}] успішно видалено!"];
        } else {
            return ['success' => false, 'message' => "Помилка видалення або статтю вже було видалено"];
        }
    }
}
