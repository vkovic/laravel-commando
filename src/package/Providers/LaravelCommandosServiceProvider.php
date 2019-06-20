<?php

namespace Vkovic\LaravelCommandos\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbCreate;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbDrop;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbDump;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbExist;

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
            __DIR__ . '/../../config' => config_path()
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-commandos.php', 'laravel-commandos');

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->commands([
            // Database related commands
            DbCreate::class,
            DbExist::class,
            DbDrop::class,
            DbDump::class,
            // Other commands
        ]);
    }
}