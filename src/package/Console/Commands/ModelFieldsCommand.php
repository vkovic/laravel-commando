<?php

namespace Vkovic\LaravelCommando\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Vkovic\LaravelCommando\Handlers\Database\WithdbHandler;
use Vkovic\LaravelCommando\Handlers\WithHelper;

class ModelFieldsCommand extends Command
{
    use WithHelper, WithdbHandler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:fields
                                {model? : Model namespace, e.g. `"\App\User"`, `"App\Models\Post"`)}
                           ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show model fields info';

    public function handle()
    {
        $database = config('database.connections.' . config('database.default') . '.database');

        // Take model from passed argument
        // or list all models within the app
        if (($modelClass = $this->argument('model')) === null) {
            $allModels = $this->helper()->getAllModelClasses();
            $modelClass = $this->choice('Choose model to show the fields from:', $allModels);
        }

        if (!class_exists($modelClass)) {
            $this->output->warning("Model `$modelClass` doesn`t exist");

            return 1;
        }

        $modelClass = ltrim($modelClass, '\\');

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
                $column['nullable'] ? 'YES' : '',
                $column['default_value'] ?? '',
                $casts[$column['name']] ?? '', // Casts
                in_array($column['name'], $guarded) ? 'YES' : '', // Guarded
                in_array($column['name'], $fillable) ? 'YES' : '' // Fillable
            ];
        }

        $this->output->text("Model: `$modelClass`");
        $this->table(['Field', 'Type', 'Nullable', 'Default', 'Casts', 'Guarded', 'Fillable'], $data);
        $this->output->newLine();
    }
}
