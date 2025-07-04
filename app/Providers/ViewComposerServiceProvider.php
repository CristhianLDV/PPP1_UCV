<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Employee;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
            View::composer('includes.add_leave', function ($view) {
        $view->with('employees', Employee::all());
    });
    
    // Opcional: para todas las vistas que lo necesiten
    View::composer('*', function ($view) {
        $view->with('employees', Employee::all());
    });
    }
}
