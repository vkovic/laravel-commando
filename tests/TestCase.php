<?php

namespace Vkovic\LaravelCommandos\Test;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\PendingCommand;
use Illuminate\Support\Arr;
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

        // This line is introduced to disable mocking object
        // (using `$this->artisan->{this_will_be_mocked_object}`)
        // so we can continue to use `Artisan::call` or `this->artisan`
        // and to get output of the command.
        // See also `artisanTest` method below.
        $this->withoutMockingConsoleOutput();
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
     * Call artisan command in tests fluently with `expects` and `assert`
     * methods (on mock object).
     *
     * See also `setUp` method above
     *
     * @param  string $command
     * @param  array  $parameters
     *
     * @return \Illuminate\Foundation\Testing\PendingCommand|int
     */
    protected function artisanTest($command, $parameters = [])
    {
        $this->beforeApplicationDestroyed(function () {
            if (count($this->expectedQuestions)) {
                $this->fail('Question "' . Arr::first($this->expectedQuestions)[0] . '" was not asked.');
            }

            if (count($this->expectedOutput)) {
                $this->fail('Output "' . Arr::first($this->expectedOutput) . '" was not printed.');
            }
        });

        return new PendingCommand($this, $this->app, $command, $parameters);
    }
}