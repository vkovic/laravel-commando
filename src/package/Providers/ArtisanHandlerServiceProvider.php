<?php

namespace Vkovic\LaravelCommandos\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommandos\Handlers\Artisan\AbstractArtisanHandler;
use Vkovic\LaravelCommandos\Handlers\Artisan\Artisan;

class ArtisanHandlerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AbstractArtisanHandler::class, function ($app) {
            return new Artisan();
        });
    }
}