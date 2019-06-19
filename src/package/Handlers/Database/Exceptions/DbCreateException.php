<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

class DbCreateException extends AbstractDbException
{
    protected $message = 'Error creating database';
}