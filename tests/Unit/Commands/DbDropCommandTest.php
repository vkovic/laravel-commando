<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Illuminate\Support\Str;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbDropCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_drop_db_when_argument_passed()
    {
        $database = Str::random();

        $this->artisan('db:create', ['database' => $database]);

        $this->artisan('db:drop', ['database' => $database])
            //->expectsOutput('Database "' . $database . '" successfully dropped')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_handle_non_existing_db()
    {
        $tempDatabase = Str::random();

        $this->switchDefaultDb($tempDatabase, function ($defaultDb) use ($tempDatabase) {
            $this->artisan('db:drop', ['database' => $tempDatabase])
                //->expectsOutput('Can not drop database "' . $tempDatabase . '". Database does not exist')
                ->assertExitCode(0);
        });
    }
}