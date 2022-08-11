<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'tag_connect');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'tag_connect');
    }
}
