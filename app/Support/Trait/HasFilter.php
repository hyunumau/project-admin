<?php

namespace App\Support\Trait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait HasFilter
{
    public function scopeFilter(Builder $query, array $filter = [])
    {
        if (Arr::has($filter, 'filter')) {
            $query->where(Arr::get($filter, 'filter'));
        }

        // if (Arr::has($filter, 'search')) {
        //     foreach (Arr::get($filter, 'search') as $column => $value) {
        //         $query->where($column, 'like', "%{$value}%");
        //     }
        // }

        return $query;
    }

    
}