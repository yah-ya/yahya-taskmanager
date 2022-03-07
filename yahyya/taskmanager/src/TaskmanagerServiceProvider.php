<?php

namespace Yahyya\taskmanager;

use Illuminate\Support\ServiceProvider;

class TaskmanagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/Database/Factories');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'taskmanager');
    }


}
