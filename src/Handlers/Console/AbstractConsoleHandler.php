<?php

namespace Vkovic\LaravelCommando\Handlers\Console;

abstract class AbstractConsoleHandler
{
    /**
     * @param string $command
     *
     * @return bool
     */
    abstract public function commandExists(string $command);

    /**
     * @param string $command
     *
     * @return string
     */
    abstract public function executeCommand(string $command);
}