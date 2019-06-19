<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\DatabaseCommands\MySql;

class DbExist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:exist
                                {database? : Database (name) to be created. If passed env DB_DATABASE will be ignored.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if db exists. If no argument passed it will check against database name from .env';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get database name either from passed argument (if any)
        // or from default database configuration
        $database = $this->argument('database') ?: (function () {
            $default = config('database.default');

            return config("database.connections.$default.database");
        })();

        $config = config()->get('database.connections.mysql');
        $db = new MySql($config);

        if ($db->databaseExists($database)) {
            $this->line('Database "' . $database . '" exist');
        } else {
            $this->line('Database "' . $database . '" does not exist');
        }
    }
}