<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'cate_connect');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tag_connect');
    }
}
