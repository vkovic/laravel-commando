<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

class DbExistCheckException extends AbstractDbException
{
    protected $message = 'Error checking database exists';
}