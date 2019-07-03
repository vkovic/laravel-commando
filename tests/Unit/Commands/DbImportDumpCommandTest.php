<?php

namespace Vkovic\LaravelCommando\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommando\Handlers\Console\AbstractConsoleHandler;
use Vkovic\LaravelCommando\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommando\Test\TestCase;

class DbImportDumpCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_1_when_dump_program_not_exist()
    {
        $this->mock(AbstractConsoleHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('commandExists')->once()->andReturn(false);
        });

        $this->artisan('db:import-dump')->assertExitCode(1);
    }

    /**
     * @test
     */
    public function it_returns_2_when_dump_not_exist()
    {
        $this->mock(AbstractConsoleHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('commandExists')->once()->andReturn(true);
        });

        $this->artisan('db:import-dump', [
            '--dir' => 'non_existing_dir',
        ])
            ->assertExitCode(2);
    }
}
