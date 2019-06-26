<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Vkovic\LaravelCommandos\Test\TestCase;

class DbImportDumpCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_exception_when_no_dump_file()
    {
        $this->expectException(\Exception::class);

        $this->artisan('db:import-dump', [
            'dump' => 'non_existing_dump.sql',
        ]);
    }

    /**
     * @test
     */
    public function it_can_react_to__i_changed_my_mind()
    {
        $database = 'laravel_commandos';
        $dump = __DIR__ . '/../../Support/files/dump.sql';
        $question = "Database '$database' exist. What should we do:";

        $this->artisan('db:import-dump', [
            'database' => $database,
            'dump' => $dump,
        ])
            ->expectsQuestion($question, 0)
            ->expectsOutput('Command aborted')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function it_can_import_on_existing_db()
    {
        $database = 'laravel_commandos';
        $dump = __DIR__ . '/../../Support/files/dump.sql';
        $question = "Database '$database' exist. What should we do:";

        $this->artisan('db:import-dump', [
            'database' => $database,
            'dump' => $dump,
        ])
            ->expectsQuestion($question, 1)
            ->expectsOutput('Done')
            ->assertExitCode(0);
    }

    /**
     */
    public function it_can_drop_and_create_db_and_import_dump()
    {
        // We need letters only. I might saw a problem when db name starts with num
        $database = 'laravel_commandos';
        $dump = __DIR__ . '/../Support/files/dump.sql';
        $question = "Database '$database' exist. What should we do:";

        $this->artisan('db:import-dump', [
            'database' => $database,
            'dump' => $dump,
        ])
            ->expectsQuestion($question, 0)
            ->expectsOutput('Done')
            ->assertExitCode(0);
    }
}