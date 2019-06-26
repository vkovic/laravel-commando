<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbExistCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_check_db_exist_when_argument_passed()
    {
        //
        // Default db exists | argument `database` omitted
        //

        $database = config()->get('database.connections.mysql.database');

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(true);
        });

        $this->artisan('db:exist')
            ->expectsOutput("Database `$database` exists")
            ->assertExitCode(0);

        //
        // Some db not exists | argument `database` present
        //

        $database = 'non_existant_db';

        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('databaseExists')->once()->andReturn(false);
        });

        $this->artisan('db:exist', ['database' => $database])
            ->expectsOutput("Database `$database` doesn`t exist")
            ->assertExitCode(0);
    }
}