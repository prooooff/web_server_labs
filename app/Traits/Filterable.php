<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    /**
     * Застосовує пошук, сортування та пагінацію до запиту.
     */
    public function applyFilters(Builder $query, Request $request, array $searchableFields = [])
    {
        // 1. Пошук (Like '-%' - пошук по початку рядка)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', $search . '%');
                }
            });
        }

        // 2. Сортування по колонках
        if ($request->filled('sort_by')) {
            $sortBy = $request->input('sort_by');
            $sortDir = $request->input('sort_dir', 'asc'); // asc або desc
            $query->orderBy($sortBy, $sortDir);
        } else {
            $query->orderBy('id', 'desc'); // Сортування за замовчуванням
        }

        // 3. Пагінація з передачею кількості на сторінці (за замовчуванням 15)
        $perPage = $request->input('per_page', 15);

        return $query->paginate($perPage);
    }
}
