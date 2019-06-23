<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Model;

use Illuminate\Console\Command;
use Vkovic\LaravelCommandos\Handlers\Database\WithDbHandler;

class ModelFieldsCommand extends Command
{
    use WithDbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:fields
                                {model? : Model namespace relative to app e.g. "User" or "App\User"}
                                {--guarded? : TODO}
                                {--fillable? : TODO}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TODO';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $default = config('database.default');
        $database = config("database.connections.$default.database");

        // Array with: name, position, type, nullable, default_value
        $columns = $this->dbHandler()->getColumns($database, 'products');

        $headers = ['Field', 'Type', 'Nullable', 'Default', 'Casts']; // TODO 'Casts': show if field casted to something

        $data = [];
        foreach ($columns as $column) {
            $data[] = [
                $column['name'], $column['type'], $column['nullable'], $column['default_value'], $casts
            ];
        }

        $this->table($headers, $data);
    }
}
