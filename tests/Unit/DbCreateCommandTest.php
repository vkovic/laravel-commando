<?php

namespace Vkovic\LaravelCommandos\Test\Unit;

use Vkovic\LaravelCommandos\Test\TestCase;

class DbCreateCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_db_when_argument_passed()
    {
        $database = 'new_database';

        $this->artisanTest('db:create', ['database' => $database])
            ->expectsOutput('Database "' . $database . '" successfully created')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_handle_already_existing_db()
    {
        $dbName = config()->get('database.connections.mysql.database');

        $this->artisanTest('db:create', ['database' => $dbName])
            ->expectsOutput('Database "' . $dbName . '" exist')
            ->assertExitCode(0);
    }
}