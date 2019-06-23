<?php

namespace Vkovic\LaravelCommandos\Handlers\Artisan;

abstract class AbstractArtisanHandler
{
    abstract public function call($command, array $parameters = [], $outputBuffer = null);
}