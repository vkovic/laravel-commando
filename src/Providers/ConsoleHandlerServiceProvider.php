<?php

namespace Vkovic\LaravelCommando\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommando\Handlers\Console\AbstractConsoleHandler;

class ConsoleHandlerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AbstractConsoleHandler::class, function ($app) {
            $system = config('laravel-commando.console.system');
            $consoleHandlerClass = config('laravel-commando.console.console_handler.' . $system);

            if ($consoleHandlerClass === null) {
                throw new \Exception('Laravel Commando console handler must be defined for os: ' . $system);
            }

            // Default Laravel database array config will be directly injected into db handler
            // so we can init custom connection (not dependant on underlying project) there
            return new $consoleHandlerClass();
        });
    }
}