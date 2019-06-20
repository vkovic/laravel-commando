<?php

namespace Vkovic\LaravelCommandos\Test;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Symfony\Component\Console\Output\BufferedOutput;
use Vkovic\LaravelCommandos\Providers\ConsoleHandlerServiceProvider;
use Vkovic\LaravelCommandos\Providers\DbHandlerServiceProvider;
use Vkovic\LaravelCommandos\Providers\LaravelCommandosServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Trick to add migration only for testing,
     * and not the one from package service provider
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            DbHandlerServiceProvider::class,
            ConsoleHandlerServiceProvider::class,
            LaravelCommandosServiceProvider::class
        ];
    }

    /**
     * 1) Switch default db to new name
     * 2) Run callback
     * 4) Switch back to old name
     *
     * @param $tempDbName
     * @param $callback
     *
     * @throws \Exception
     */
    protected function switchDefaultDb($tempDbName, $callback)
    {
        // Switch default db to new name
        $defaultDb = config()->get('database.connections.mysql.database');
        config()->set('database.connections.mysql.database', $tempDbName);

        // Run callback
        $callback($defaultDb);

        // Switch back to old name
        config()->set('database.connections.mysql.database', $defaultDb);
    }
}