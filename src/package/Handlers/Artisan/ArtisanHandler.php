<?php

namespace Vkovic\LaravelCommandos\Handlers\Artisan;

use Illuminate\Support\Facades\Artisan;

class ArtisanHandler extends AbstractArtisanHandler
{
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        return Artisan::call($command, $parameters, $outputBuffer);
    }
}