<?php

namespace Vkovic\LaravelCommando\Handlers;

trait WithHelper
{
    /**
     * @return Helper
     */
    public function helper()
    {
        return app()->make(Helper::class);
    }
}