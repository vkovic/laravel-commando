<?php

namespace Vkovic\LaravelCommando\Handlers\Console;

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