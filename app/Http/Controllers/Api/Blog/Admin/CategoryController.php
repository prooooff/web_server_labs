<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Repositories\BlogCategoryRepository;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Resources\Api\CategoryResource;

class CategoryController extends BaseController
{
    private $blogCategoryRepository;

    public function __construct(BlogCategoryRepository $blogCategoryRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(15);

        return CategoryResource::collection($paginator);
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return ['success' => true, 'data' => $item];
        } else {
            return ['success' => false, 'message' => 'Помилка збереження'];
        }
    }

    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return ['success' => false, 'message' => 'Запис не знайдено'];
        }

        $data = $request->all();
        $result = $item->update($data);

        if ($result) {
            return ['success' => true, 'data' => $item];
        } else {
            return ['success' => false, 'message' => 'Помилка збереження'];
        }
    }
}
