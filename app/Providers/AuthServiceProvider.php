<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [

    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('modules', function($user, $permissionName){
            if($user->publish == 0) return false;
            $permission = $user->user_catalogues_tables->permissions;
            if($permission->contains('canonical', $permissionName)){
                return true;
            }
            return false;
        });
    }
}
