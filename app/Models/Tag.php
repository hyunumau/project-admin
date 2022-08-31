<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

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
