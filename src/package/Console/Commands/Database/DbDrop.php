<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Database;

use DB;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class DbDrop extends Command
{
    use ConfirmableTrait;

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
    protected $signature = 'db:drop 
                               {database? : Database (name) to be dropped. If passed env DB_DATABASE will be ignored.} 
                               {--force : Force the operation to run when in production.}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables, views and functions in current DB (migration table also)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->db = env('DB_DATABASE');

        parent::__construct();
    }

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

        $this->db = $this->argument('database') ?? env('DB_DATABASE');
        DB::connection()->getPdo()->exec('USE ' . $this->db);

        // Drop tables and views
        $this->dropTables();
        $this->dropViews();

        // Drop functions / procedures
        $this->dropFunctions();

        // Extra line at the end
        echo(PHP_EOL);
    }

    private function dropTables()
    {
        // Select tables only (not views)
        $tables = DB::select("SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'");

        if (empty($tables)) {
            $this->comment(PHP_EOL . "$this->db DB has no tables");
        } else {
            if ($this->confirm("All tables in $this->db DB will be deleted! Do you really want to continue?")) {
                $colname = 'Tables_in_' . $this->db;

                DB::beginTransaction();
                DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                foreach ($tables as $table) {
                    $this->comment("Dropping {$table->$colname} table");
                    DB::unprepared("DROP TABLE `{$table->$colname}`");
                }
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
                DB::commit();
            } else {
                $this->comment(PHP_EOL . 'Command aborted' . PHP_EOL);
            }
        }
    }

    private function dropViews()
    {
        // Select views only (not tables)
        $views = DB::select("SHOW FULL TABLES WHERE Table_Type = 'VIEW'");

        if (empty($views)) {
            $this->comment(PHP_EOL . "$this->db DB has no views");
        } else {
            if ($this->confirm("All views in $this->db DB will be deleted! Do you really want to continue?")) {
                $colname = 'Tables_in_' . $this->db;

                DB::beginTransaction();
                foreach ($views as $table) {
                    $this->comment("Dropping {$table->$colname} view");
                    DB::unprepared("DROP VIEW `{$table->$colname}`");
                }
                DB::commit();
            } else {
                $this->comment(PHP_EOL . 'Command aborted' . PHP_EOL);
            }
        }
    }

    private function dropFunctions()
    {
        $results = DB::select(sprintf("SHOW FUNCTION STATUS WHERE db='%s'", $this->db));

        if (empty($results)) {
            $this->comment(PHP_EOL . "$this->db DB has no functions");
        } else {
            if ($this->confirm("All functions in $this->db DB will be deleted! Do you really want to continue?")) {
                DB::beginTransaction();
                foreach ($results as $result) {
                    $this->comment("Dropping $result->Name function");
                    DB::unprepared("DROP FUNCTION $this->db.$result->Name");
                }
                DB::commit();
            } else {
                $this->comment(PHP_EOL . 'Command aborted' . PHP_EOL);
            }
        }
    }
}
