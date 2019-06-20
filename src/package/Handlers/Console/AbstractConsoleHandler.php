<?php

namespace Vkovic\LaravelCommandos\Handlers\Console;

abstract class AbstractConsoleHandler
{
    abstract public function commandExists(string $command): bool;

    abstract public function executeCommand(string $command): string;
}