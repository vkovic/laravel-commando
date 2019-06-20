<?php

namespace Vkovic\LaravelCommandos\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractHandler;
use Vkovic\LaravelCommandos\Handlers\Database\MySql;

class DbHandlerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AbstractHandler::class, function ($app) {
            // TODO
            // Other cases instead of mysql (sqlite, postgress ...)
            $config = config()->get('database.connections.mysql');
            return new MySql($config);
        });
    }
}