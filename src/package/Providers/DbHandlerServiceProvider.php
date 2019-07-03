<?php

namespace Vkovic\LaravelCommando\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommando\Handlers\Database\AbstractDbHandler;

class DbHandlerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AbstractDbHandler::class, function ($app) {
            $connectionName = config('laravel-commando.database.connection');
            $config = config()->get('database.connections.' . $connectionName);
            $driver = $config['driver'];
            $dbHandlerClass = config('laravel-commando.database.driver_handler.' . $driver);

            if ($dbHandlerClass === null) {
                throw new \Exception('Laravel Commando driver handler must be defined for driver: ' . $driver);
            }

            // Default Laravel database array config will be directly injected into db handler
            // so we can init custom connection (not dependant on underlying project) there
            return new $dbHandlerClass($config);
        });
    }
}