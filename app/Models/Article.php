<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['caption', 'author', 'detail', 'image', 'publish'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getImageUrlAttribute()
    {
        $value = $this->attributes['image'];

        if (preg_match('/^http(s)*\:\/\/[a-zA-Z0-9\-_\.]+\//i', $value)) {
            return $value;
        }
        return Storage::url($value);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tag_connect');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'cate_connect');
    }

    public function authorInfo()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
