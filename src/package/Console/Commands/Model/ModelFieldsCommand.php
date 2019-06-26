<?php

namespace Vkovic\LaravelCommandos\Console\Commands\Model;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
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
                                {model : Model namespace relative to app e.g. "User" or "App\User"}
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
        $modelClass = 'App\\' . $this->argument('model');
        /** @var Model $model */
        $model = new $modelClass;
        $casts = $model->getCasts();
        $fillable = $model->getFillable();
        $guarded = $model->getGuarded();

        // Array with: name, position, type, nullable, default_value
        $columns = $this->dbHandler()->getColumns($database, $model->getTable());

        $data = [];
        foreach ($columns as $i => $column) {
            $data[$i] = [
                $column['name'],
                $column['type'],
                $column['nullable'] ? 'YES' : null,
                $column['default_value'] ?? '',
                $casts[$column['name']] ?? '', // Casts
                in_array($column['name'], $guarded) ? 'YES' : '', // Guarded
                in_array($column['name'], $fillable) ? 'YES' : '' // Fillable
            ];
        }

        $this->table(['Field', 'Type', 'Nullable', 'Default', 'Casts', 'Guarded', 'Fillable'], $data);
    }
}
