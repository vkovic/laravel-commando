<?php

namespace Vkovic\LaravelCommando\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommando\Console\Commands\DbCreateCommand;
use Vkovic\LaravelCommando\Console\Commands\DbDropCommand;
use Vkovic\LaravelCommando\Console\Commands\DbDumpCommand;
use Vkovic\LaravelCommando\Console\Commands\DbExistCommand;
use Vkovic\LaravelCommando\Console\Commands\DbImportDumpCommand;
use Vkovic\LaravelCommando\Console\Commands\DbSummonCommand;
use Vkovic\LaravelCommando\Console\Commands\ModelFieldsCommand;
use Vkovic\LaravelCommando\Console\Commands\ModelListCommand;
use function Vkovic\LaravelCommando\src_path;

class LaravelCommandoServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(src_path('config/laravel-commando.php'), 'laravel-commando');

        $this->registerProviders();

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->commands([
            //
            // Database related commands
            //

            DbCreateCommand::class,
            DbDropCommand::class,
            DbDumpCommand::class,
            DbExistCommand::class,
            DbImportDumpCommand::class,
            DbSummonCommand::class,

            //
            // Model commands
            //

            ModelFieldsCommand::class,
            ModelListCommand::class,
        ]);
    }

    /**
     * Register service providers on which
     */
    protected function registerProviders()
    {
        $this->app->register(ConsoleHandlerServiceProvider::class);
        $this->app->register(DbHandlerServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);
    }
}