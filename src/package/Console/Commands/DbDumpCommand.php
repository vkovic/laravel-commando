<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Console\WithConsoleHandler;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class DbDumpCommand extends Command
{
    use WithConsoleHandler, WithDbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump
                                {database? : Db (name) to be dump. If omitted, it`ll use default db name from env}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump database to file';

    public function handle()
    {
        // TODO
        // Implement arguments that user can pass to customize dump process.
        // Also add easy gzip fn

        // Get database name either from passed argument (if any)
        // or from default database configuration
        $database = $this->argument('database') ?: (function () {
            $default = config('database.default');

            return config("database.connections.$default.database");
        })();

        if (!$this->dbHandler()->databaseExists($database)) {
            return $this->warn("Database `$database` doesn`t exist");
        }

        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $destination = storage_path("$database-" . Carbon::now()->format('Y-m-d-H-i-s') . '.sql');

        // Omit view definer so we do not come across missing user on another system
        $removeDefiner = "| sed -e 's/DEFINER[ ]*=[ ]*[^*]*\*/\*/'";

        // Avoid database prefix being written into dump file
        $removeDbPrefix = "| sed -e 's/`$database`.`/`/g'";

        $command = "mysqldump -h $host -u$user -p$password $database $removeDefiner $removeDbPrefix > $destination";

        $this->consoleHandler()->executeCommand($command);

        $this->info("Database `$database` dumped");
        $this->line("Destination: `$destination`");
    }
}
