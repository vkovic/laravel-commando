<?php

namespace Vkovic\LaravelCommandos\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbCreate;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbDrop;
use Vkovic\LaravelCommandos\Console\Commands\Database\DbExist;

class LaravelCommandosServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->commands([
            // Database related commands
            DbCreate::class,
            DbExist::class,
            DbDrop::class,
            // Other commands
        ]);
    }
}