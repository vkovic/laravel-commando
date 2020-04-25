<?php

namespace Vkovic\LaravelCommando\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommando\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommando\Test\TestCase;

class DbExistCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_0_when_db_exists()
    {
        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
        });

        $this->artisan('db:exist')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_returns_0_when_db_not_exists()
    {
        $database = 'non_existent_db';

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
        });

        $this->artisan('db:exist', ['database' => $database])
            ->assertExitCode(0);
    }
}