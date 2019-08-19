<?php

namespace Vkovic\LaravelCommando\Providers;

use Illuminate\Support\ServiceProvider;
use Vkovic\LaravelCommando\Handlers\Helper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Helper::class, function ($app) {
            return new Helper;
        });
    }
}