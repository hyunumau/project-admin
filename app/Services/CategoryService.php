<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function create($data)
    {
        DB::beginTransaction();

        try {
            
            $category = $this->category->fill($data);
            
            $category->save();
            
            if(isset($data['tags'])){
                $category->tags()->sync($data['tags']);
            }
            
            
            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return null;
        }
    }

    public function update($data, $category)
    {

        DB::beginTransaction();

        try {
            $category->name = $data['name'];
            $category->fill($data)->save();
            
            if(isset($data['tags'])){
                $category->tags()->sync($data['tags']);
            }
            
            DB::commit();

            return $category;
            
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return null;
        }
    }

    public function delete($category)
    {
        $category->delete();
    }
}
