<?php

namespace Vkovic\LaravelCommandos\DatabaseCommands;

interface DatabaseCommandsInterface
{
    public static function databaseExists($dbName);

    public static function createDatabase($dbName);

    public static function dropDatabase($dbName);
}