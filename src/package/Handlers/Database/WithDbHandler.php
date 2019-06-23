<?php

namespace Vkovic\LaravelCommandos\Handlers\Database;

trait WithDbHandler
{
    public function dbHandler()
    {
        return app()->make(AbstractDbHandler::class);
    }
}