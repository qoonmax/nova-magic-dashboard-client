<?php

namespace App\Console\Commands\Pipe;

use Illuminate\Http\Request;
use function Laravel\Prompts\note;
use function Laravel\Prompts\spin;

class ClientEnvironmentPipe extends Pipe
{
    public function handle(Request $request, callable $next): Request
    {
        spin(fn() => sleep(2), "🔎  Getting the environment data...");

        $phpVersion = phpversion() ?? null;
        $laravelVersion = app()->version() ?? null;

        $composerLock = json_decode(file_get_contents(base_path('composer.lock')), true);

        $novaVersion = collect($composerLock['packages'])
            ->where('name', 'laravel/nova')
            ->pluck('version')
            ->first() ?? null;
        $dbmsName = config('database.default') ?? null;

        $variables = [
            'php_version' => $phpVersion,
            'laravel_version' => $laravelVersion,
            'nova_version' => $novaVersion,
            'dbms_name' => $dbmsName
        ];

        foreach ($variables as $name => $value) {
            if ($value === null) {
                $formattedName = ucfirst(str_replace('_', ' ', $name));
                note("Environment error: {$formattedName} not found.", 'error');
                die();
            }
        }

        $request->merge([
            'client_environment' => $variables
        ]);

        return $next($request);
    }
}
