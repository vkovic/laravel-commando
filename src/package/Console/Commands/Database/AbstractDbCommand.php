<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractHandler;

class AbstractDbCommand extends Command
{
    /**
     * Database operations handler
     *
     * @var AbstractHandler
     */
    protected $dbHandler;

    public function __construct(AbstractHandler $dbHandler)
    {
        parent::__construct();

        $this->dbHandler = $dbHandler;
    }
}
