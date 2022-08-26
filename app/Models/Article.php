<?php

namespace App\Models;

use App\Support\Trait\HasFilter;
use App\Support\Trait\HasPagination;
use App\Support\Trait\HasSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory, HasFilter, HasPagination, HasSearch, SoftDeletes;

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

    public function scopeSearchCategories(Builder $query, array $categories)
    {
        if (! empty($categories)) {
            $query->orWhereHas('categories', function ($builder) use ($categories) {
                $builder->whereIn('id', $categories);
            });
        }

        return $query;
    }

}
