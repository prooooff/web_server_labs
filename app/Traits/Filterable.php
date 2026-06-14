<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeSearchByField(Builder $query, ?string $search, string $field = 'title'): Builder
    {
        if (!empty($search)) {
            return $query->where($field, 'LIKE', $search . '%');
        }

        return $query;
    }

    public function scopeSortByField(Builder $query, string $field, string $direction = 'desc'): Builder
    {
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'desc';
        return $query->orderBy($field, $direction);
    }
}
