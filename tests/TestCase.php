<?php

namespace Vkovic\LaravelCommando\Test;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vkovic\LaravelCommando\Providers\CommandoServiceProvider;
use function Vkovic\LaravelCommando\package_path;

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
            CommandoServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Mimic laravel default env functionality and load env vars from .env
        (Dotenv::create(package_path(), '.env'))->load();
    }
}