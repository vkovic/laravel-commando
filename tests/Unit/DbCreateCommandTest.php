<?php

namespace Vkovic\LaravelCommandos\Test\Unit;

use Illuminate\Support\Str;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbCreateCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_db_when_argument_passed()
    {
        $database = Str::random();

        $this->artisan('db:create', ['database' => $database])
            ->expectsOutput('Database "' . $database . '" successfully created')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_handle_already_existing_db()
    {
        $database = config()->get('database.connections.mysql.database');

        $this->artisan('db:create', ['database' => $database])
            ->expectsOutput('Can not create database "' . $database . '". Database already exists')
            ->assertExitCode(0);
    }
}