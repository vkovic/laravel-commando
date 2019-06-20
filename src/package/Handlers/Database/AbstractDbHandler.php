<?php

namespace Vkovic\LaravelCommandos\Handlers\Database;

abstract class AbstractDbHandler
{
    abstract public function databaseExists($database): bool;

    abstract public function createDatabase($database): void;

    abstract public function dropDatabase($database): void;
}