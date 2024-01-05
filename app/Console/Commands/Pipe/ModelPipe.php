<?php

namespace App\Console\Commands\Pipe;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Laravel\Prompts\note;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;

class ModelPipe extends Pipe
{
    public function handle(Request $request, callable $next): Request
    {
        spin(fn() => sleep(5), "🔎  I'm looking for models in your project...");

        $modelsPath = app_path('Models');
        $files = scandir($modelsPath);

        $models = array_filter($files, function ($file) {
            return $file !== '.' && $file !== '..' && Str::endsWith($file, '.php');
        });

        if (!empty($models)) {
            note(
                message: 'The models folder is not empty. Please make sure that you have a backup of the models folder before continuing.',
                type: 'alert'
            );

            note(
                message: implode(' ', array_map(fn($model) => "[$model]", $models)),
                type: 'warning'
            );

            $permission = select(
                label: 'Do you want to continue?',
                options: [
                    true => 'Yes, delete all models and resources and continue.',
                    false => 'No, I want stop it.',
                ],
                default: false,
                hint: 'Select the extra tables using the arrows.'
            );

            if (!$permission) {
                spin(fn() => sleep(2), "🛑  I'm finishing the process...");
                die();
            }
        }

        return $next($request);
    }
}
