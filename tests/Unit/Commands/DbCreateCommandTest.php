<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbCreateCommandTest extends TestCase
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
        });

        $this->artisan('db:create')
            ->expectsOutput("Database `$database` exists")
            ->assertExitCode(0);

        //
        // Some db not exists | argument `database` present
        //

        $database = 'non_existent_db';

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
            $mock->shouldReceive('createDatabase')->once()->andReturn(null);
        });

        $this->artisan('db:create', ['database' => $database])
            ->expectsOutput("Database `$database` created successfully")
            ->assertExitCode(0);
    }
}