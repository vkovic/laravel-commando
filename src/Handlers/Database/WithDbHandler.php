<?php

namespace Vkovic\LaravelCommando\Handlers\Database;

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