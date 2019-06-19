<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

use Throwable;

abstract class AbstractDbException extends \Exception
{
    protected $coreMessage;

    public function __construct(string $coreMessage = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($this->message, $code, $previous);

        $this->coreMessage = $coreMessage;
    }
}