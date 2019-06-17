<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class DbImportDump extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import-dump 
                                {database? : Which database to use as import destination. Db from env will be used if none passed}
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
        if (\App::environment('production')) {
            // TODO
            $this->error("Command can't be run in production (for now)");
        }

        $this->verifyMysqlPakcageExists();

        $database = $this->argument('database') ?? env('DB_DATABASE');
        $this->call('db:create', ['database' => $database]);

        $host = env('DB_HOST');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        $dump = storage_path('dump.sql');

        if (!file_exists($dump)) {
            $this->error('file not exist');
            return 1;
        }

        $command = "mysql -h $host -u$user -p$password $database < $dump";
        if (!`$command`) {
            $this->info("Dump loaded into database: $database");
        } else {
            $this->error('Command failed');
        }
    }

    protected function verifyMysqlPakcageExists()
    {
        // If `mysqldump` bash command not found
        if (!`which mysql`) {
            $this->error('`mysql` package does not exit');
            $this->info('You can install `mysql` by running `apt install mysql-client`');
            exit(1);
        }
    }
}
