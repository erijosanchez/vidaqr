<?php

namespace App\Providers;

use App\Models\EmergencyContact;
use App\Policies\EmergencyContactPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        EmergencyContact::class => EmergencyContactPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
