<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
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
        $articles = new Article;
        $articles = $articles->latest()->paginate(5);;
        return view('admin.article.index', compact('articles'))
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
        $dataInsert = $request->validate([
            'caption' => 'required',
            'author' => 'required',
            'detail' => 'required',
            'image' => 'required',
        ]);

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
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
        $dataInsert = $request->validate([
            'caption' => 'required',
            'author' => 'required',
            'detail' => 'required',
            'image' => 'required',
        ]);

        $article->caption = $request->caption;
        $article->author = $request->author;
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
        $article->delete();

        return redirect()->route('article.index')
            ->with('message', 'Xoá thành công');
    }

    public function getAll()
    {
        return Article::all();
    }
}
