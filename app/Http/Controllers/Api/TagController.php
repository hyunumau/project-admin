<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;

    function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->tagService
        ->getList([])
        ->sortBy("name")
        ->values()
        ->toArray();
    }

    public function show($id)
    {
        return Tag::with(['articles'])
            ->where('id', $id)
            ->first()
            ->toArray();
    }
}
