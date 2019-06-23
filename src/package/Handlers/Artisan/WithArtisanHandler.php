<?php

namespace Vkovic\LaravelCommandos\Handlers\Artisan;

trait WithArtisanHandler
{
    public function artisanHandler()
    {
        return app()->make(AbstractArtisanHandler::class);
    }
}