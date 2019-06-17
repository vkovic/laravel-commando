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
        $dbName = config()->get('database.connections.mysql.database');

        $this->artisan('db:exist')
            ->expectsOutput('Database "' . $dbName . '" exist')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_check_db_not_exist_when_argument_passed()
    {
        $dbName = 'non_existing_db';

        $this->artisan('db:exist', ['database' => $dbName])
            ->expectsOutput('Database "' . $dbName . '" does not exist')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_check_db_not_exist_when_argument_omitted()
    {
        $dbName = 'non_existing_db_x';
        config()->set('database.connections.mysql.database', $dbName);

        $this->artisan('db:exist')
            ->expectsOutput('Database "' . $dbName . '" does not exist')
            ->assertExitCode(0);
    }
}