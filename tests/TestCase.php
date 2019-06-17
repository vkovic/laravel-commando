<?php

namespace Vkovic\LaravelCommandos\Test;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Symfony\Component\Console\Output\BufferedOutput;
use Vkovic\LaravelCommandos\Providers\LaravelCommandosServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * @var BufferedOutput
     */
    private $outputBuffer;

    /**
     * @var array
     */
    private $output = [];

    /**
     * @var int
     */
    private $exitCode = -1;

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

        $this->outputBuffer = new BufferedOutput;
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

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->setUpDatabase();
    }

    /**
     * Setup default database used for testing
     */
    protected function setUpDatabase()
    {
        $this->switchDefaultDb(null, function ($defaultDb) {
            DB::statement("CREATE DATABASE IF NOT EXISTS $defaultDb");
        });
//        // Set database name to `null`
//        // so we can create db without error
//        // and than return it to normal
//        $database = config()->get('database.connections.mysql.database');
//        config()->set('database.connections.mysql.database', null);
//
//        DB::statement("CREATE DATABASE IF NOT EXISTS $database");
//
//        // Reset database name
//        config()->set('database.connections.mysql.database', $database);
    }

    public function artisan($command, $parameters = [])
    {
        $this->exitCode = (int) Artisan::call($command, $parameters, $this->outputBuffer);

        $output = explode("\n", $this->outputBuffer->fetch());
        array_pop($output);
        $this->output = $output;

        return $this;
    }

    protected function expectsOutput($expected)
    {
        $this->assertContains($expected, $this->output);

        return $this;
    }

    protected function assertExitCode($expected)
    {
        $this->assertEquals($expected, $this->exitCode);
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