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
     * @return Column[]
     */
    public function getFields(string $tableName): array
    {
        $columns = DB::select('SELECT * FROM information_schema.columns WHERE table_name = ?', [$tableName]);

        //TODO: get foreign key from pg_constraint OR try to predict it from the name
        $foreignKeys = DB::select("
            SELECT a.attname AS column_name,
                confrelid::regclass AS referenced_table_name,
                (SELECT attname
                FROM pg_attribute
                WHERE attrelid = confrelid
                    AND attnum = ANY(confkey)) AS referenced_owner_key
            FROM pg_constraint
                JOIN pg_attribute a ON a.attnum = ANY(conkey) AND a.attrelid = conrelid
            WHERE  contype = 'f'
                AND connamespace = 'public'::regnamespace
            ORDER  BY conrelid::regclass::text, contype DESC;
        ");

        foreach ($columns as $column) {
            foreach ($foreignKeys as $foreignKey) {
                if ($foreignKey->column_name === $column->column_name) {
                    $column->is_foreign_key = true;
                    $column->referenced_table_name = $foreignKey->referenced_table_name;
                    $column->referenced_owner_key = $foreignKey->referenced_owner_key;
                }
            }
        }

        return array_map(function ($field) {
            return new Column($field);
        }, $columns);
    }

    /**
     * @param string $tableName
     * @return array
     */
    public function getData(string $tableName): array
    {
        $lastFiveRecords = DB::table($tableName)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return $lastFiveRecords->toArray();
    }

}
