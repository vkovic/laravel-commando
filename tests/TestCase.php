<?php

namespace Vkovic\LaravelCommandos\Test;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vkovic\LaravelCommandos\Providers\LaravelCommandosServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        //$this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Trick to add migration only for testing,
     * and not the one from package service provider
     *
     * @param Application $app
     *
     * @return string
     */
    protected function getPackageProviders($app)
    {
        //return ConsoleServiceProvider::class;
        return LaravelCommandosServiceProvider::class;
    }
}