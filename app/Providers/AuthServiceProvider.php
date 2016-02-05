<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\Vendor' => 'App\Policies\VendorPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\UserAddress' => 'App\Policies\UserAddressPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        /*
        foreach (get_class_methods(new \App\Policies\ProductPolicy) as $method) {
            $gate->define($method, "App\Policies\ProductPolicy@{$method}");
        }*/

        $this->registerPolicies($gate);
    }
}
