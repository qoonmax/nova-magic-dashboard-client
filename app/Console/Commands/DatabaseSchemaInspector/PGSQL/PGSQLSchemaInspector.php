<?php

namespace App\Console\Commands\DatabaseSchemaInspector\PGSQL;

use App\Console\Commands\DatabaseSchemaInspector\DatabaseSchemaInspector;
use Illuminate\Support\Facades\DB;

class PGSQLSchemaInspector implements DatabaseSchemaInspector
{
    /**
     * @return string[]
     */
    public function getTableNames(): array
    {
        $tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema=\'public\'');

        return array_map(function ($table) {
            return $table->table_name;
        }, $tables);
    }

    /**
     * @param string $tableName
     * @return Field[]
     */
    public function getFields(string $tableName): array
    {
        $fields = DB::select('SELECT * FROM information_schema.columns WHERE table_name = ?', [$tableName]);

        return array_map(function ($field) {
            return new Field($field);
        }, $fields);
    }

    /**
     * @param string $tableName
     * @return array
     */
    public function getData(string $tableName): array {
        $lastFiveRecords = DB::table($tableName)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return $lastFiveRecords->toArray();
    }

}
