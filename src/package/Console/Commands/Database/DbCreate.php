<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DbCreate extends Command
{
    /**
     * Current database name (from env)
     *
     * @var string
     */
    protected $db;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create
                                {database? : Database (name) to be created. If passed env DB_DATABASE will be ignored.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create db defined in .env file or with custom name if argument passed';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get database name either from passed argument (if any)
        // or from default database configuration
        $database = $this->argument('database') ?: (function () {
            $default = config('database.default');

            return config("database.connections.$default.database");
        })();

        Artisan::call('db:exist', ['database' => $database]);
        $message = trim(Artisan::output());

        if (strpos($message, 'not exist') !== false) {
            DB::statement("CREATE DATABASE $database");

            $this->line('Database "' . $database . '" successfully created');
        } else {
            $this->line('Can not create database "' . $database . '". Database already exists');
        }
    }
}
