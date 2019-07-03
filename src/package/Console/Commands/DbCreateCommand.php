<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;

class DbCreateCommand extends Command
{
    /**
     * @var AbstractDbHandler
     */
    protected $dbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create
                                {database? : Db (name) to be created. If omitted, it`ll use default db name from env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create db defined in .env file or with custom name if argument passed';

    public function __construct(AbstractDbHandler $dbHandler)
    {
        parent::__construct();

        $this->dbHandler = $dbHandler;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $database = $this->argument('database')
            ?: config('database.connections.' . config('database.default') . '.database');

        if ($this->dbHandler->databaseExists($database)) {
            $this->output->warning("Database `$database` exists");

            return 1;
        }

        $this->dbHandler->createDatabase($database);

        $this->output->success("Database `$database` created successfully");
    }
}
