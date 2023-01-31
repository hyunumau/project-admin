<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Article;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Cấp full quyền cho "Super-Admin", role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->is_superadmin) {
                return true;
            }
        });

        foreach(Permission::all() as $permission)
        {
            Gate::define($permission->name, function(User $user) use ($permission){
                return $user->hasPermission($permission);
            });
        }

        Gate::define('can_do', function(User $user, $permissionName) {
            return $user->hasPermission($permissionName);
        });

        Gate::define('update-article', function (User $user, $article) {
            return $user->id === $article->author;
        });
    }
}
