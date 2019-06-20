<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;

class AbstractConsoleCommand extends Command
{
    /**
     * Database operations handler
     *
     * @var AbstractDbHandler
     */
    protected $consoleHandler;

    public function __construct(AbstractConsoleCommand $dbHandler)
    {
        parent::__construct();

        $this->consoleHandler = $dbHandler;
    }
}