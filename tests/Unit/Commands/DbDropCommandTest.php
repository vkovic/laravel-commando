<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbDropCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_follows_flow()
    {
        //
        // Default db | argument `database` omitted
        //

        $database = config()->get('database.connections.mysql.database');

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
            $mock->shouldReceive('dropDatabase')->once();
        });

        $this->artisan('db:drop')
            ->expectsOutput("Database `$database` dropped successfully")
            ->assertExitCode(0);

        //
        // Some db not exists | argument `database` present
        //

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
        });

        $this->artisan('db:drop')
            ->expectsOutput("Database `$database` doesn`t exist")
            ->assertExitCode(0);
    }
}