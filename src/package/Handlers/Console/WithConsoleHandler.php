<?php

namespace Vkovic\LaravelCommandos\Handlers\Console;

trait WithConsoleHandler
{
    /**
     * @return AbstractConsoleHandler
     */
    public function consoleHandler()
    {
        return app()->make(AbstractConsoleHandler::class);
    }
}