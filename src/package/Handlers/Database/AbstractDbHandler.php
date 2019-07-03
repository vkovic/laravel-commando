<?php

namespace Vkovic\LaravelCommando\Handlers\Database;

abstract class AbstractDbHandler
{
    /**
     * @param string $database
     *
     * @return bool
     */
    abstract public function databaseExists($database);

    /**
     * @param $database
     *
     * @return void
     */
    abstract public function createDatabase($database);

    /**
     * @param $database
     *
     * @return void
     */
    abstract public function dropDatabase($database);

    /**
     * @param $database
     * @param $table
     *
     * @return array Example. Array with: `name`, `position`, `type`, `nullable`, `default_value`
     */
    abstract public function getColumns($database, $table);
}