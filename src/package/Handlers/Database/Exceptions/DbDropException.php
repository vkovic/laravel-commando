<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

class DbDropException extends AbstractDbException
{
    protected $message = 'Error dropping database';
}