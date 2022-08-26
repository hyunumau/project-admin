<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        return $this->articleService->getList([
            ...$request->query(),
            'with' => ['authorInfo', 'tags:id,name', 'categories:id,name'],
            'filter' => ['publish' => 1],
        ])->toArray();
    }

    public function show($id)
    {
        return Article::with(['authorInfo', 'tags:id,name', 'categories:id,name'])
            ->where('id', $id)
            ->where('publish', 1)
            ->first()
            ->toArray();
    }
}
