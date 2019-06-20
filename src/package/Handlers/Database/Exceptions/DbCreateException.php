<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

class DbCreateException extends AbstractDbException
{
    public static function getLocalMessage(): string
    {
        return 'Error creating database';
    }
}