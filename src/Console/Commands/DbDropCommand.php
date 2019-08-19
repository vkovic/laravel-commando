<?php

namespace Vkovic\LaravelCommando\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommando\Handlers\Database\WithDbHandler;

class DbDropCommand extends Command
{
    use WithDbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop
                               {database? : Database to drop. If omitted, name from .env will be used.} 
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop database';

    public function handle()
    {
        $database = $this->argument('database')
            ?: config('database.connections.' . config('database.default') . '.database');

        // Check if db exists
        if (!$this->dbHandler()->databaseExists($database)) {
            $this->output->warning("Database `$database` doesn`t exist");

            return 1;
        }

        // Confirm
        if (!$this->confirm("Do you really wish to drop `$database` database?")) {
            $this->output->note('Command aborted');

            return 255;
        }

        $this->dbHandler()->dropDatabase($database);

        $this->output->success("Database `$database` dropped successfully");
    }
}
