<?php

namespace Vkovic\LaravelCommandos\Handlers\Console;

class LinuxHandler extends AbstractConsoleHandler
{
    public function commandExists(string $command): bool
    {
        $output = exec('which ' . $command);

        return $output !== '';
    }

    public function executeCommand(string $command): string
    {
        return (string) shell_exec($command);
    }
}