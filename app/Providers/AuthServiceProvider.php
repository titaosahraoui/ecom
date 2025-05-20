<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Address;
use App\Models\Gallery;
use App\Models\Payment;
use App\Policies\AddressPolicy;
use App\Policies\GalleryPolicy;
use App\Policies\PaymentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Address::class => AddressPolicy::class,
        Payment::class => PaymentPolicy::class,
        Gallery::class => GalleryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define role-based gates
        Gate::define('isAdmin', function ($user) {
            dd($user);
            return $user->role === 'admin';
        });
        Gate::define('isCommercial', function (User $user) {
            return $user->hasRole(User::ROLE_COMMERCIAL);
        });

        Gate::define('isCustomer', function (User $user) {
            return $user->hasRole(User::ROLE_CUSTOMER);
        });

        // Optional: Blade directives
        Gate::after(function ($user, $ability) {
            return $user->hasRole(User::ROLE_ADMIN); // Admins can do anything
        });
    }
}
