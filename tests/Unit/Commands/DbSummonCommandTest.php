<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommandos\Handlers\Artisan\AbstractArtisanHandler;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbSummonCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_perform_summon()
    {
        // Mock db handler
        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
            $mock->shouldReceive('dropDatabase')->once();
            $mock->shouldReceive('createDatabase')->once();
        });

        // Mock artisan handler
        $this->mock(AbstractArtisanHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('call')->once()->with('migrate');
            $mock->shouldReceive('call')->once()->with('db:seed');
        });

        $this->artisan('db:summon')
            ->expectsOutput('Done')
            ->assertExitCode(0);
    }
}