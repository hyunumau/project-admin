<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * hhh
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getList(array $filter = [])
    {
        $query = $this->article->query()->latest();
        
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

    public function create ($request)
    {
        $dataInsert = $request->validate([
            'caption' => 'required',
            'detail' => 'required',
            'image' => 'required',
        ]);
        $dataInsert['author'] = auth()->user()->id;
        $dataInsert['publish'] = 0;

        $addArticle = Article::create($dataInsert);
        $addCategory = [];
        $addTag = [];

        DB::beginTransaction();
        foreach ($request->categories as $category) {
            $cate_id = Category::where('name', $category)->first()->id;
            array_push($addCategory, $cate_id);
        }

        foreach ($request->tags as $tag) {
            $tag_id = Tag::where('name', $tag)->first()->id;
            array_push($addTag, $tag_id);
        }

        $addArticle->categories()->sync($addCategory);
        $addArticle->tags()->sync($addTag);

        DB::commit();
    }

    public function update ($request, $article)
    {
        $request->validate([
            'caption' => 'required',
            'detail' => 'required',
            'image' => 'required',
        ]);

        $article->caption = $request->caption;
        $article->detail = $request->detail;
        $article->image = $request->image;
        $addCategories = [];
        $addTags = [];

        foreach ($request->categories as $category) {
            $cate_id = Category::where('name', $category)->first()->id;
            array_push($addCategories, $cate_id);
        }

        foreach ($request->tags as $tag) {
            $tag_id = Tag::where('name', $tag)->first()->id;
            array_push($addTags, $tag_id);
        }

        $article->categories()->sync($addCategories);
        $article->tags()->sync($addTags);
        $article->save();
    }

    public function delete($article)
    {
        $article->tags()->detach();
        $article->categories()->detach();
        $article->delete();
    }
}
