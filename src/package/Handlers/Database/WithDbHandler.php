<?php

namespace Vkovic\LaravelCommandos\Handlers\Database;

trait WithDbHandler
{
    /**
     * @return AbstractDbHandler
     */
    public function dbHandler()
    {
        return app()->make(AbstractDbHandler::class);
    }
}