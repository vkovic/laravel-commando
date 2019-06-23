<?php

namespace Vkovic\LaravelCommandos\Handlers\Database;

abstract class AbstractDbHandler
{
    abstract public function databaseExists($database): bool;

    abstract public function createDatabase($database): void;

    abstract public function dropDatabase($database): void;

    /**
     * @param $database
     * @param $table
     *
     * @return array Example. Array with: `name`, `position`, `type`, `nullable`, `default_value`
     */
    abstract public function getColumns($database, $table): array;
}