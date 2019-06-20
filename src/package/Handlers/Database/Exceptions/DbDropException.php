<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

class DbDropException extends AbstractDbException
{
    public static function getLocalMessage(): string
    {
        return 'Error dropping database';
    }
}