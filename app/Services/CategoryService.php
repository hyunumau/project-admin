<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * hhh
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getList(array $filter = [])
    {
        $query = $this->category->query()->latest();

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

        $addCategory = Category::create($dataInsert);
        $addTag = [];

        DB::beginTransaction();

        foreach ($request->tags as $tag) {
            $tag_id = Tag::where('name', $tag)->first()->id;
            array_push($addTag, $tag_id);
        }
        $addCategory->tags()->syncWithoutDetaching($addTag);
    }

    public function update($request, $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $addTag = [];
        foreach ($request->tags as $tag) {
            $tag_id = Tag::where('name', $tag)->first()->id;
            array_push($addTag, $tag_id);
        }
        $category->name = $request->name;
        $category->tags()->sync($addTag);
        $category->save();
    }

    public function delete($category)
    {
        $category->tags()->detach();
        $category->articles()->detach();
        $category->delete();
    }
}
