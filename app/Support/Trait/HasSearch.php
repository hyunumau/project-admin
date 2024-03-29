<?php

namespace App\Support\Trait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait HasSearch
{
    public function scopeSearchAll(Builder $query, $filter, array $columns)
    {
        if (Arr::has($filter, 'search')) {
            $value = Arr::get($filter, 'search');

            $query->where(function ($query) use ($columns, $value) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'ilike', "%{$value}%");
                }
            });
        }

        return $query;
    }
}
