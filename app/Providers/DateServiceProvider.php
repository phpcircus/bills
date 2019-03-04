<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;

class DateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        Date::use(CarbonImmutable::class);
    }
}
