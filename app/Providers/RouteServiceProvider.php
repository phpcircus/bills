<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /** @var string */
    protected $authNamespace = 'App\Http\Controllers';

    /** @var string */
    protected $actionNamespace = 'App\Http\Actions';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapAuthRoutes();
        $this->mapActionRoutes();
    }

    /**
     * Define the auth routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapAuthRoutes()
    {
        Route::middleware('web')
            ->namespace($this->authNamespace)
            ->group(base_path('routes/auth.php'));
    }

    /**
     * Define the action routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapActionRoutes()
    {
        Route::middleware('web')
             ->namespace($this->actionNamespace)
             ->group(base_path('routes/actions.php'));
    }
}
