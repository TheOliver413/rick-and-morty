<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Usar Bootstrap para la paginación
        Paginator::useBootstrap();

        // Personalizar los iconos de paginación
        \Illuminate\Pagination\AbstractPaginator::$defaultSimpleView = 'pagination::simple-bootstrap-5';
        \Illuminate\Pagination\AbstractPaginator::$defaultView = 'pagination::bootstrap-5';
    }
}
