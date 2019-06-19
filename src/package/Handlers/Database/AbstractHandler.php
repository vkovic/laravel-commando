<?php

namespace Vkovic\LaravelCommandos\Handlers;

abstract class AbstractHandler
{
    abstract public function databaseExists($database);

    abstract public function createDatabase($database);

    abstract public function dropDatabase($database);
}