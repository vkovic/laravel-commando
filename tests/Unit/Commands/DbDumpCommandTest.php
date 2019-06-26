<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Vkovic\LaravelCommandos\Test\TestCase;

class DbDumpCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_dump()
    {
        $this->artisan('db:dump')
            //->expectsOutput('Done')
            ->assertExitCode(0);

        $this->assertFileExists(storage_path('dump.sql'));

        unlink(storage_path('dump.sql'));
    }
}