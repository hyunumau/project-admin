<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $author = auth()->id();
        $authoredit = User::find($author);
        $articles = new Article;

        $articles = $articles->with(['authorInfo'])->latest()->paginate(5);

        return view('admin.article.index', compact('articles', 'authoredit'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
    public function store(Request $request)
    {
        $author = auth()->user()->id;
        $request->author = $author;

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

        try {
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

            return redirect()->route('article.index')
                ->with('message', 'Tạo thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Thêm thất bại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $articleHasCategories = array_column(json_decode($article->categories, true), 'id');
        $articleHasTags = array_column(json_decode($article->tags, true), 'id');

        return view('admin.article.show', compact('article', 'categories', 'articleHasCategories', 'tags', 'articleHasTags'));
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
    public function update(Request $request, Article $article)
    {
        try {
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

            DB::commit();

            return redirect()->route('article.index')
                ->with('message', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('error', 'Sửa thất bại');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->tags()->detach();
        $article->categories()->detach();
        $article->delete();

        return redirect()->route('article.index')
            ->with('message', 'Xoá thành công');
    }

    public function getAll()
    {
        return Article::all();
    }

    public function getById($id)
    {
        return Article::find($id);
    }

    public function changePublish($id)
    {
        $article = Article::find($id);
        $this->authorize('articles publish', $article);
        $article->publish = !($article->publish);
        $article->save();

        return redirect()->route('article.index');
    }

    public function getTagArticles($id)
    {
        $article = Article::find($id);
        return ($article->tags);
    }
    public function getCategoryArticles($id)
    {
        $article = Article::find($id);
        return ($article->categories);
    }
}
