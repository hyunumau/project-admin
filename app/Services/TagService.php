<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TagService
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * hhh
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getList(array $filter = [])
    {
        $query = $this->tag->query()->latest();

        if (Arr::has($filter, 'with')) {
            $query->with(Arr::get($filter, 'with'));
        }

        if (Arr::has($filter, 'filter')) {
            $query->where(Arr::get($filter, 'filter'));
        }

        if (Arr::has($filter, 'search')) {
            foreach (Arr::get($filter, 'search') as $column => $value) {
                $query->where($column, 'like', "%{$value}%");
            }
        }

        if (Arr::has($filter, 'paginate')) {
            return $query->paginate(Arr::get($filter, 'paginate'));
        }

        return $query->get();
    }

    public function create($request)
    {
        $dataInsert = $request->validate([
            'name' => 'required',
        ]);

        Tag::create($dataInsert);
    }

    public function update($request, $tag)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $tag->name = $request->name;
        $tag->save();
    }

    public function delete($tag)
    {
        $tag->articles()->detach();
        $tag->delete();
    }
}
