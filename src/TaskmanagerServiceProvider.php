<?php

namespace Yahyya\taskmanager;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Yahyya\taskmanager\App\Http\Middleware\CheckAuthToken;
use Yahyya\taskmanager\App\Interfaces\LabelRepositoryInterface;
use Yahyya\taskmanager\App\Interfaces\TaskRepositoryInterface;
use Yahyya\taskmanager\App\Repositories\LabelRepository;
use Yahyya\taskmanager\App\Repositories\TaskRepository;

class TaskmanagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LabelRepositoryInterface::class,LabelRepository::class);
        $this->app->bind(TaskRepositoryInterface::class,TaskRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadFactoriesFrom(__DIR__ . '/Database/Factories');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'taskmanager');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('CheckAuthToken', CheckAuthToken::class);
    }


}
