<?php

namespace Vkovic\LaravelCommando\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommando\Handlers\Database\WithDbHandler;

class DbExistCommand extends Command
{
    use WithDbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:exist
                                {database? : Database name to check. If omitted it`ll check for default db (defined in .env).}';

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
        $database = $this->argument('database')
            ?: config('database.connections.' . config('database.default') . '.database');

        if ($this->dbHandler()->databaseExists($database)) {
            $this->output->note("Database `$database` exists");
        } else {
            $this->output->note("Database `$database` doesn`t exist");
        }
    }
}