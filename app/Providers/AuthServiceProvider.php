<?php

namespace App\Providers;

use App\Models\Part;
use App\Policies\PartPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Part::class => PartPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
