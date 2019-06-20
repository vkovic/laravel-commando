<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Vkovic\LaravelCommandos\Handlers\Database\AbstractHandler;
use Vkovic\LaravelCommandos\Handlers\Database\Exceptions\AbstractDbException;

class DbDrop extends AbstractDbCommand
{
    /**
     * Database operations handler
     *
     * @var AbstractHandler
     */
    protected $dbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop
                               {database? : Database (name) to be created. If passed env DB_DATABASE will be ignored} 
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get database name either from passed argument (if any)
        // or from default database configuration
        $database = $this->argument('database') ?: (function () {
            $default = config('database.default');

            return config("database.connections.$default.database");
        })();

        $this->info("Dropping database: '$database'");

        if (!$this->dbHandler->databaseExists($database)) {
            return $this->line('Database does not exist');
        }

        try {
            $this->dbHandler->dropDatabase($database);
        } catch (AbstractDbException $e) {
            return $this->error($e->getMessage());
        }

        $this->info('Done');
    }
}
