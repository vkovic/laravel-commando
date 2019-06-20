<?php

namespace Vkovic\LaravelCommandos\Handlers\Database\Exceptions;

abstract class AbstractDbException extends \Exception
{
    protected $coreMessage;

    public function __construct(string $coreMessage = "", int $code = 0, Throwable $previous = null)
    {
        // Inject our (local message) instead of core message
        // but preserve it and make it accessible
        parent::__construct(static::getLocalMessage(), $code, $previous);

        $this->coreMessage = $coreMessage;
    }

    abstract public static function getLocalMessage(): string;

    /**
     * Access core exception message
     *
     * @return string
     */
    public function getCoreMessage(): string
    {
        return $this->coreMessage;
    }
}