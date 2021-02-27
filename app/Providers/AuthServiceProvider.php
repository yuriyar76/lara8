<?php

namespace App\Providers;

use App\Models\Article;
use App\Policies\ArticlePolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Article::class => ArticlePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('VIEW_ADMIN', function (User $user){
            return $user->canDo('VIEW_ADMIN');
        });
        Gate::define('VIEW_ADMIN_ARTICLES', function (User $user){
            return $user->canDo('VIEW_ADMIN_ARTICLES');
        });
        //
    }
}
