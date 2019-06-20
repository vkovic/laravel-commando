<?php

namespace Vkovic\LaravelCommandos\Handlers\Database;

abstract class AbstractHandler
{
    abstract public function databaseExists($database): bool;

    abstract public function createDatabase($database): void;

    abstract public function dropDatabase($database): void;
}