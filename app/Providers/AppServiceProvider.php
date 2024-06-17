<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Observers\PostObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Post::observe(PostObserver::class);

        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });

        // al momento de llamar este gate, espera que como parametro se le pase un post, el user ya lo capta por defecto
        Gate::define('author', function ($user, $post) {
            return $user->id === $post->user_id;
        });
    }
}
