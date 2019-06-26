<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class DbExistCommand extends Command
{
    use WithDbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:exist
                                {database? : Db (name) to be checked for existence. If omitted, it`ll check for default db defined in env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if database exists';

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

        if ($this->dbHandler()->databaseExists($database)) {
            return $this->info("Database `$database` exists");
        } else {
            return $this->warn("Database `$database` doesn`t exist");
        }
    }
}