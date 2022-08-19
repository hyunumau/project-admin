<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\ArticleService;


class ArticleController extends Controller
{
    protected $articleService;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {

        $filter = ['paginate' => 5];
        $articles = $this->articleService->getList($filter);

        $authoredit = auth()->user();
        return view('admin.article.index', compact('articles', 'authoredit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.article.create', compact('categories', "tags"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleService->create($request->validated());

        if (is_null($article)) {
            return back()->with('error', 'Thêm thất bại');
        }

        return redirect()->route('article.index')
            ->with('message', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $articleHasCategories = array_column(json_decode($article->categories, true), 'id');
        $articleHasTags = array_column(json_decode($article->tags, true), 'id');

        return view('admin.article.edit', compact('article', 'categories', 'articleHasCategories', 'tags', 'articleHasTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->articleService->update($request->validated(), $article);

        return redirect()->route('article.index')
            ->with('message', 'Cập nhật thành công');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->articleService->delete($article);

        return redirect()->route('article.index')
            ->with('message', 'Xoá thành công');
    }

    public function changePublish($id)
    {
        $article = Article::find($id);
        $article->publish = !($article->publish);
        $article->save();
        return redirect()->route('article.index');
    }
}
