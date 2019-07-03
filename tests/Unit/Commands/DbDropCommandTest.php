<?php

namespace Vkovic\LaravelCommando\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommando\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommando\Test\TestCase;

class DbDropCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_1_when_db_not_exist()
    {
        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
        });

        $this->artisan('db:drop')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function it_returns_255_on_user_abort()
    {
        $database = config()->get('database.connections.mysql.database');

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
        });

        $this->artisan('db:drop')
            ->expectsQuestion("Do you really wish to drop `$database` database?", false)
            ->assertExitCode(255);
    }

    /**
     * @test
     */
    public function it_returns_0_when_db_dropped()
    {
        $database = config()->get('database.connections.mysql.database');

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
            $mock->shouldReceive('dropDatabase')->once();
        });

        $this->artisan('db:drop')
            ->expectsQuestion("Do you really wish to drop `$database` database?", true)
            ->assertExitCode(0);
    }
}