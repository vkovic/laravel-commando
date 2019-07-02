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
    public function it_returns_1_when_db_exists()
    {
        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
        });

        $this->artisan('db:create')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function it_returns_0_when_db_created()
    {
        $database = 'non_existent_db';

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
            $mock->shouldReceive('createDatabase')->once();
        });

        $this->artisan('db:create', ['database' => $database])
            ->assertExitCode(0);
    }
}