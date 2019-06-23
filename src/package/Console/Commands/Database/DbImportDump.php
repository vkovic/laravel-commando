<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Vkovic\LaravelCommandos\Handlers\Console\WithConsoleHandler;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class DbImportDump extends Command
{
    use ConfirmableTrait, WithDbHandler, WithConsoleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import-dump 
                                {database? : Which database to use as import destination. Db from env will be used if none passed}
                                {dump? : Which dump file to use as import source. TODO: Which one will be used if none passed}
                                {--force : Force operation to run when in production.}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import dump to database (env default or passed one)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // TODO
        // Implement arguments that user can pass to customize dump process.
        // Also add easy gzip fn

        $dump = $this->argument('dump') ?: storage_path('dump.sql');

        if (!file_exists($dump)) {
            throw new \Exception('Dump file for import not exists');
        }

        // Get database name either from passed argument (if any)
        // or from default database configuration
        $database = $this->argument('database') ?: (function () {
            $default = config('database.default');

            return config("database.connections.$default.database");
        })();

        //
        // What if db exists? .. or not? Dive
        //

        if ($this->dbHandler()->databaseExists($database)) {
            $message = "Database '$database' exist. What should we do:";
            $choices = [
                'Oh, I changed my mind, I dont want to import dump for now',
                'Yeah, import dump over',
                'Drop database (!!!CaUtIoN!!) and than import dump',
            ];

            $choice = $this->choice($message, $choices, 0);

            if ($choice == 0) {
                return $this->line('Command aborted');
            }

            if ($choice == 2) {
                $this->dbHandler()->createDatabase($database);
                $this->dbHandler()->dropDatabase($database);
            }

            // If dump is 1 we'll do nothing
        } else {
            $message = "Database '$database' not exist. What should we do:";
            $choices = [
                'Oh, I changed my mind, I dont want to import dump for now',
                "Yeah, create '$database' and import dump over",
            ];

            $choice = $this->choice($message, $choices, 0);

            if ($choice == 0) {
                return $this->line('Command aborted');
            }

            if ($choice == 1) {
                $this->dbHandler()->createDatabase($database);
            }
        }

        //
        // Lets run the command and import dump
        //

        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');
        $host = env('DB_HOST');

        $command = "mysql -h $host -u$user -p$password $database < $choice";

        $this->consoleHandler()->executeCommand($command);

        $this->info('Done');
    }
}