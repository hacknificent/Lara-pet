<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        //
        Gate::define('view-admin-panel', function ($user) {
            return true || $user->is_admin;
        });
        
        Gate::define('view-all-projects', function ($user) {
            return true;
        });
    }
}
