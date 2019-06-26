<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Vkovic\LaravelCommandos\Handlers\Console\WithConsoleHandler;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class DbImportDumpCommand extends Command
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

        // Check if requirenments are met
        if (!$this->consoleHandler()->commandExists('mysql')) {
            $this->warn('`mysql` program required');
            return $this->info('e.g. on Ubuntu you can install `mysql` by running `apt install mysql-client`');
        }

        // Prepara db dump file
        $dump = $this->argument('dump') ?: storage_path('dump.sql');

        if (!file_exists($dump)) {
            throw new \Exception('Dump file for import not exist');
        }

        // Get database name either from passed argument (if any)
        // or from default database configuration
        $database = $this->argument('database') ?: (function () {
            $default = config('database.default');

            return config("database.connections.$default.database");
        })();

        //
        // What do to if db exists?
        // .. or what to do if not?
        //

        if ($this->dbHandler()->databaseExists($database)) {
            $message = "Database '$database' exist. What should we do:";
            $choices = [
                'I changed my mind, I don`t want to import dump',
                "Import dump over existing database `$database`",
                "Recreate `$database` database (!!! CAUTION !!!) and than import dump",
            ];

            $choice = $this->choice($message, $choices, 0);

            if ($choice == $choices[0]) {
                return $this->line('Command aborted');
            }

            if ($choice == $choices[2]) {
                $this->dbHandler()->dropDatabase($database);
                $this->dbHandler()->createDatabase($database);
            }

            // If choice is 1 we'll do nothing
        } else {
            $message = "Database '$database' not exist. What should we do:";
            $choices = [
                'Oh, I changed my mind, I don`t want to import dump for now',
                "Yeah, create database '$database' and import dump",
            ];

            $choice = $this->choice($message, $choices, 0);

            if ($choice == $choices[0]) {
                return $this->line('Command aborted');
            }

            if ($choice == $choices[1]) {
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

        $command = "mysql -h $host -u$user -p$password $database < $dump";

        $this->consoleHandler()->executeCommand($command);

        $this->info('Done');
    }
}