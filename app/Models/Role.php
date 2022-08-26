<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as OriginalRole;

class Role extends OriginalRole
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'guard_name',
        'updated_at',
        'created_at'
    ];

    
}