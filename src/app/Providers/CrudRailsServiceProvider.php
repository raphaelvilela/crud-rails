<?php

namespace RaphaelVilela\CrudRails\App\Providers;

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
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'crud-rails');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => base_path('resources/views/raphaelvilela/crud-rails'),
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
        $this->app->make('RaphaelVilela\CrudRails\App\Controllers\ModelController');
    }
}
