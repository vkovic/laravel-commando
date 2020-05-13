<?php

namespace Vkovic\LaravelCommando\Test;

use Dotenv\Dotenv;
use Illuminate\Foundation\Application;
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
        // (Pre Laravel 7 Dotenv (< v4) used different constructor)
        $dotenv = ((int) Application::VERSION) >= 7
            ? Dotenv::createImmutable(package_path(), '.env')
            : Dotenv::create(package_path(), '.env');

        $dotenv->load();
    }
}