<?php

namespace Vkovic\LaravelCommandos\Test\Unit;

use Vkovic\LaravelCommandos\Test\TestCase;

class DbExistCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_check_db_exist_when_argument_passed()
    {
        $dbName = config()->get('database.connections.mysql.database');

        $this->artisan('db:exist', ['database' => $dbName])
            ->expectsOutput('Database "' . $dbName . '" exist')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_check_db_exist_when_argument_omitted()
    {
        $database = config()->get('database.connections.mysql.database');

        $this->artisan('db:exist')
            ->expectsOutput('Database "' . $database . '" exist')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_check_db_not_exist_when_argument_passed()
    {
        $database = 'non_existing_db';

        $this->artisan('db:exist', ['database' => $database])
            ->expectsOutput('Database "' . $database . '" does not exist')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_check_db_not_exist_when_argument_omitted()
    {
        $database = 'non_existing_db';
        config()->set('database.connections.mysql.database', $database);

        $this->artisan('db:exist')
            ->expectsOutput('Database "' . $database . '" does not exist')
            ->assertExitCode(0);
    }
}