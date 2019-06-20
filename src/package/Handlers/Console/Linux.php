<?php

namespace Vkovic\LaravelCommandos\Handlers\Console;

class Linux extends AbstractConsoleHandler
{
    public function commandExists(string $command): bool
    {
        $output = exec('which ' . $command);

        return $output !== '';
    }

    public function executeCommand(string $command): string
    {
        return exec($command);
    }
}