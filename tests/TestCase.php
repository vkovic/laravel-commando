<?php

namespace Vkovic\LaravelCommando\Test;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vkovic\LaravelCommando\Providers\LaravelCommandoServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelCommandoServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Mimic laravel default env functionality and load env vars from .env
        (Dotenv::create(__DIR__ . '/../', '.env'))->load();
    }
}