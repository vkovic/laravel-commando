<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

class DbExistCheckException extends AbstractDbException
{
    public static function getLocalMessage(): string
    {
        return 'Error checking database exists';
    }
}