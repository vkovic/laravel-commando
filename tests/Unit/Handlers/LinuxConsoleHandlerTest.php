<?php

namespace Vkovic\LaravelCommando\Test\Unit\Handlers;

use Vkovic\LaravelCommando\Handlers\Console\LinuxHandler;
use Vkovic\LaravelCommando\Test\TestCase;

class LinuxConsoleHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_check_if_command_exists()
    {
        $linuxHandler = new LinuxHandler;

        $existingCommand = 'php';
        $nonExistingCommand = 'non-existing-package';

        $this->assertTrue($linuxHandler->commandExists($existingCommand));
        $this->assertFalse($linuxHandler->commandExists($nonExistingCommand));
    }

    /**
     * @test
     */
    public function it_can_execute_command()
    {
        $linuxHandler = new LinuxHandler;

        $output = $linuxHandler->executeCommand('ls /dev/null');

        $this->assertStringContainsString('/dev/null', $output);
    }
}