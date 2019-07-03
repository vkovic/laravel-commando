<?php

namespace Vkovic\LaravelCommandos\Handlers;

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