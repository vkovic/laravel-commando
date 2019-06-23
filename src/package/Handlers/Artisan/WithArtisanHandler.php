<?php

namespace Vkovic\LaravelCommandos\Handlers\Artisan;

trait WithArtisanHandler
{
    /**
     * @return AbstractArtisanHandler
     */
    public function artisanHandler()
    {
        return app()->make(AbstractArtisanHandler::class);
    }
}