<?php

namespace Vkovic\LaravelCommandos\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbCreateCommand;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbDropCommand;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbDumpCommand;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbExistCommand;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbImportDumpCommand;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbSummonCommand;
use Vkovic\LaravelCommandos\Console\Commands\Model\ModelFieldsCommand;

class LaravelCommandosServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            src_path('config') => config_path()
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(src_path('config/laravel-commandos.php'), 'laravel-commandos');

        $this->registerProviders();

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->commands([
            // Database related commands
            DbCreateCommand::class,
            DbExistCommand::class,
            DbDropCommand::class,
            DbDumpCommand::class,
            DbImportDumpCommand::class,
            DbSummonCommand::class,
            // Model commands
            ModelFieldsCommand::class
        ]);
    }

    /**
     * Register service providers on which
     */
    protected function registerProviders()
    {
        $this->app->register(DbHandlerServiceProvider::class);
        $this->app->register(ConsoleHandlerServiceProvider::class);
        $this->app->register(ArtisanHandlerServiceProvider::class);
    }
}