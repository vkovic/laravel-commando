<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class DbDump extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump 
                                {--force : Force the operation to run when in production.}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump default (env defined) database without db prefix and view definer';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return 1;
        }

        $this->verifyMysqldumpExists();

        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');
        $host = env('DB_HOST');
        $dump = storage_path('dump.sql');

        // Omit view definer so we do not come across missing user on another system
        $removeDefiner = "| sed -e 's/DEFINER[ ]*=[ ]*[^*]*\*/\*/'";

        // Avoid database prefix being written into dump file
        $removeDbPrefix = "| sed -e 's/`$database`.`/`/g'";

        $command = "mysqldump -h $host -u$user -p$password $database $removeDefiner $removeDbPrefix > $dump";
        if (!`$command`) {
            $this->info('Dump created at: ' . $dump);
        } else {
            $this->error('Command failed');
        }
    }

    protected function verifyMysqldumpExists()
    {
        // If `mysqldump` bash command not found
        if (!`which mysqldump`) {
            $this->error('mysqldump command does not exit');
            $this->info('You can install mysqldump by running `apt install mysql-client`');
            exit(1);
        }
    }
}
