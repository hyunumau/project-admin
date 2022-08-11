<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['caption', 'author', 'detail', 'image'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tag_connect');
    }
    public function categories()
    {
        return $this->morphToMany(Category::class, 'cate_connect');
    }
}
