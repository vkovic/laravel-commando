<?php

namespace Vkovic\LaravelCommando\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommando\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommando\Handlers\Helper;
use Vkovic\LaravelCommando\Test\TestCase;

class DbSummonCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_255_on_user_abort()
    {
        $this->artisan('db:summon')
            ->expectsQuestion('Do you really wish to continue?', false)
            ->assertExitCode(255);
    }

    /**
     * @test
     */
    public function it_returns_0_when_db_summoned()
    {
        // Mock db handler
        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
            $mock->shouldReceive('dropDatabase')->once();
            $mock->shouldReceive('createDatabase')->once();
        });

        // Mock artisan handler
        $this->mock(Helper::class, function (MockInterface $mock) {
            $mock->shouldReceive('artisanCall')->once()->with('migrate');
            $mock->shouldReceive('artisanCall')->once()->with('db:seed');
        });

        $this->artisan('db:summon')
            ->expectsQuestion('Do you really wish to continue?', true)
            ->assertExitCode(0);
    }
}