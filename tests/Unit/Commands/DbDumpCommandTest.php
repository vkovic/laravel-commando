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
    public function it_follows_flow()
    {
        //
        // Default db | argument `database` omitted
        //

        $database = config()->get('database.connections.mysql.database');

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
        });

        $this->mock(AbstractConsoleHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('executeCommand')->once();
        });

        $this->artisan('db:dump')
            ->expectsOutput("Database `$database` dumped")
            ->assertExitCode(0);

        //
        // Non existent db | argument `database` present
        //

        $database = 'non_existent_db';

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
        });

        $this->artisan('db:dump', ['database' => $database])
            ->expectsOutput("Database `$database` doesn`t exist")
            ->assertExitCode(0);
    }
}