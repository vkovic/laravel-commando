<?php

namespace Vkovic\LaravelCommandos\Handlers\Console;

trait WithConsoleHandler
{
    public function consoleHandler()
    {
        return app()->make(AbstractConsoleHandler::class);
    }
}