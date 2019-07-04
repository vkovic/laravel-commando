<?php

namespace Vkovic\LaravelCommando\Console\Commands;

use Illuminate\Console\Command;
use Vkovic\LaravelCommando\Handlers\Console\WithConsoleHandler;
use Vkovic\LaravelCommando\Handlers\Database\WithDbHandler;

class DbImportDumpCommand extends Command
{
    use WithDbHandler, WithConsoleHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import-dump 
                                {database? : Database to import dump to. If omitted, name from .env will be used.}
                                {--dir= : Directory for dump lookup. If omitted default filesystem dir will be used.}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import dump from `.sql` file';

    public function handle()
    {
        // TODO
        // Implement arguments that user can pass to customize dump process.
        // Also add easy gzip fn

        // Check if requirements are met
        if (!$this->consoleHandler()->commandExists('mysql')) {
            $this->output->warning('`mysql` program required');
            $this->output->note('e.g. on Ubuntu you can install `mysql` by running `apt install mysql-client`');
            $this->output->newLine();

            return 1;
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
            $this->output->warning('There`s no .sql dump files available at ' . $dir);
            $this->output->note('You can specify custom dir with `--dir` option');

            return 2;
        }

        // Show choices ordered by dump file name
        asort($dumps);
        $this->output->text('Lookup dir: ' . $dir);
        $dump = $this->choice('Choose dump to be imported:', array_reverse($dumps), 0);

        $database = $this->argument('database')
            ?: config('database.connections.' . config('database.default') . '.database');

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
                $this->output->note('Command aborted');

                return 255;
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
                $this->output->note('Command aborted');

                return 255;
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

        $this->output->success('Dump file imported successfully');
    }
}