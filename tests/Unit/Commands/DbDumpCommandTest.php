<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommandos\Handlers\Console\AbstractConsoleHandler;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbDumpCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_1_when_db_exists()
    {
        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
        });

        $this->artisan('db:dump')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function it_returns_0_when_db_dumped()
    {
        $database = config()->get('database.connections.mysql.database');

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
        });

        $this->mock(AbstractConsoleHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('executeCommand')->once();
        });

        $this->artisan('db:dump')
            ->assertExitCode(0);
    }
}