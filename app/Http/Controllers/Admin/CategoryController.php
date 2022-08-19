<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = new Category;
        $categories = $categories->latest()->paginate(5);
        return view('admin.category.index', compact('categories'))
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
        return view('admin.category.create', compact("tags"));
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
            'name' => 'required',
        ]);

        $addCategory = Category::create($dataInsert);
        $addTag = [];

        foreach ($request->tags as $tag) {
            $tag_id = Tag::where('name', $tag)->first()->id;
            array_push($addTag, $tag_id);
        }
        $addCategory->tags()->syncWithoutDetaching($addTag);

        return redirect()->route('category.index')
            ->with('message', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $tags = Tag::all();
        $categoryHasTags = array_column(json_decode($category->tags, true), 'id');
        return view('admin.category.edit', compact('category', 'tags', 'categoryHasTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $dataInsert = $request->validate([
            'name' => 'required',
        ]);

        $addTag = [];

        foreach ($request->tags as $tag) {
            $tag_id = Tag::where('name', $tag)->first()->id;
            array_push($addTag, $tag_id);
        }
        $category->tags()->sync($addTag);   

        return redirect()->route('category.index')
            ->with('message', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
