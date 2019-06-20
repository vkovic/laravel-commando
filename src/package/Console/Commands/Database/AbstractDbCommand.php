<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Console\AbstractConsoleHandler;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;

class AbstractDbCommand extends Command
{
    /**
     * Database operations handler
     *
     * @var AbstractDbHandler
     */
    protected $dbHandler;

    /**
     * Console operations handler
     *
     * @var AbstractDbHandler
     */
    protected $consoleHandler;

    public function __construct(AbstractDbHandler $dbHandler)
    {
        parent::__construct();

        $this->dbHandler = $dbHandler;
        $this->consoleHandler = app()->make(AbstractConsoleHandler::class);
    }
}
