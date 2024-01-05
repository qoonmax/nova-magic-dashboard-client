<?php

namespace App\Console\Commands\Pipe;

use App\Console\Commands\DatabaseSchemaInspector\SchemaInspectorFactory;
use App\Console\Commands\Exceptions\DriverNotSupported;
use Illuminate\Http\Request;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\note;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class DatabasePipe extends Pipe
{
    const IGNORED_TABLES = [
        'migrations',
        'password_reset_tokens',
        'action_events',
        'failed_jobs',
        'personal_access_tokens',
        'nova_notifications',
        'nova_pending_field_attachments',
        'nova_field_attachments',
    ];

    public function handle(Request $request, callable $next): Request
    {
        $databaseDriver = config('database.default');

        try {
            $schemaInspector = SchemaInspectorFactory::make($databaseDriver);
        } catch (DriverNotSupported $e) {
           note("Database error: ". $e->getMessage(), 'error');
           die();
        }

        $tableNames = spin(fn() => $schemaInspector->getTableNames(), "🔎  I'm scanning the database...");


        usort($tableNames, function ($a, $b) {
            $aInPartial = in_array($a, self::IGNORED_TABLES);
            $bInPartial = in_array($b, self::IGNORED_TABLES);

            if ($aInPartial && !$bInPartial) {
                return 1;
            } elseif (!$aInPartial && $bInPartial) {
                return -1;
            }

            return 0;
        });

        $selectedTables = multiselect(
            label: 'Select the tables you want to see in the Nova panel. (space bar to select)',
            options: $tableNames,
            default: array_diff($tableNames, self::IGNORED_TABLES),
            scroll: 15,
            required: true,
            hint: 'Select the extra tables using the arrows and the space bar.'
        );

        $tables = [];
        foreach ($selectedTables as $tableName) {
            $tables[] = [
                'name' => $tableName,
                'fields' => spin(fn() => (array) $schemaInspector->getFields($tableName), "🔎  I'm scanning the database..."),
                'data' => spin(fn() => $schemaInspector->getData($tableName), "🔎  I'm scanning the database..."),
            ];
        }

        $request->merge([
            'database' => [
                'tables' => $tables
            ]
        ]);

        return $next($request);
    }
}
