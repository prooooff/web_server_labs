<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;

class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getPublishedWithPaginate($perPage = null, $search = null)
    {
        $perPage = (int) $perPage > 0 ? (int) $perPage : 10;
        $columns = ['id', 'title', 'slug', 'is_published', 'published_at', 'user_id', 'category_id'];

        return $this->startConditions()
            ->select($columns)
            ->where('is_published', 1)
            ->searchByField($search, 'title')
            ->orderBy('id', 'DESC')
            ->with(['category:id,title', 'user:id,name'])
            ->paginate($perPage);
    }

    // ТУТ ВАЖЛИВО: додано параметри $sortBy та $sortDir
    public function getAllWithPaginate($perPage = null, $search = null, $sortBy = 'id', $sortDir = 'desc')
    {
        $perPage = (int) $perPage > 0 ? (int) $perPage : 25;

        // ДОДАНО content_raw, щоб текст підтягувався у форму
        $columns = ['id', 'title', 'slug', 'is_published', 'published_at', 'user_id', 'category_id', 'content_raw'];

        return $this->startConditions()
            ->select($columns)
            ->searchByField($search, 'title') // Викликає Scope з Моделі
            ->sortByField($sortBy, $sortDir)  // Викликає Scope з Моделі
            ->with(['category:id,title', 'user:id,name'])
            ->paginate($perPage);
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }
}
