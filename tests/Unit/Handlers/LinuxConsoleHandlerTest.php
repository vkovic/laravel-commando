<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Handlers;

use Vkovic\LaravelCommandos\Handlers\Console\LinuxHandler;
use Vkovic\LaravelCommandos\Test\TestCase;

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

        $this->assertContains('/dev/null', $output);
    }
}