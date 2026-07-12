<?php

namespace App\Providers;

use App\Models\User;
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
        Gate::before(function (User $user) {
            return $user->role === 'admin' ? true : null;
        });

        Gate::define('access-operational-modules', function (User $user) {
            return in_array($user->role, ['admin', 'staff'], true);
        });

        Gate::define('manage-finance', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
