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
        // We need letters only. I might saw a problem when db name starts with num
        $database = preg_replace('/[0-9]+/', '', Str::random());

        $this->artisan('db:create', ['database' => $database])
            //->expectsOutput('Done')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_handle_already_existing_db()
    {
        $database = config()->get('database.connections.mysql.database');

        $this->artisan('db:create', ['database' => $database])
            //->expectsOutput('Done')
            ->assertExitCode(0);
    }
}