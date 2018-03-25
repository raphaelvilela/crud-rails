<?php

namespace RaphaelVilela\CrudRails\Providers;

use Illuminate\Support\ServiceProvider;

class CrudRailsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'crud-rails');

        $this->publishes([
            __DIR__.'/../../views' => base_path('resources/views/raphaelvilela/crud-rails'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/../../routes/web.php';
        $this->app->make('RaphaelVilela\CrudRails\Controllers\ModelController');
    }
}
