<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory as ViewFactory;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        ViewFactory::macro('component', function ($name, $data = []) {
            return View::make('app', ['name' => $name, 'data' => $data]);
        });
    }
}
