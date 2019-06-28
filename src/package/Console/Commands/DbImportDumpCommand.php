<?php

namespace Vkovic\LaravelCommandos\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Console\FormatOutput;
use Vkovic\LaravelCommandos\Handlers\Console\WithConsoleHandler;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class DbImportDumpCommand extends Command
{
    use WithDbHandler, WithConsoleHandler, FormatOutput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import-dump 
                                {database? : Which database to use as import destination. Db from env will be used if none passed}
                                {--dir= : Directory to scan for sql dumps. If omitted default filesystem dir will be used}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import dump to database (env default or passed one)';

    public function handle()
    {
        // TODO
        // Implement arguments that user can pass to customize dump process.
        // Also add easy gzip fn

        // Check if requirements are met
        if (!$this->consoleHandler()->commandExists('mysql')) {
            $this->warn('`mysql` program required');

            return $this->info('e.g. on Ubuntu you can install `mysql` by running `apt install mysql-client`');
        }

        //
        // Choose dump to load
        //

        $dir = $this->option('dir')
            ?: config('filesystems.disks.' . config('filesystems.default') . '.root');

        $dumps = [];
        foreach (glob($dir . DIRECTORY_SEPARATOR . '*.sql') as $file) {
            $dumps[] = str_replace($dir . DIRECTORY_SEPARATOR, '', $file);
        }

        if (empty($dumps)) {
            $this->warn('There`s no .sql dump files available at ' . $dir);

            return $this->warn('You can specify custom dir with `--dir` option');
        }

        // Show choices ordered by dump file name
        asort($dumps);
        $this->skipLine()->line('Lookup dir: ' . $dir);
        $dump = $this->choice('Choose dump to be imported:', array_reverse($dumps), 0);

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

        $dump = $dir . DIRECTORY_SEPARATOR . $dump;
        $command = "mysql -h $host -u$user -p$password $database < $dump";

        $this->consoleHandler()->executeCommand($command);

        $this->info('Done');
    }
}