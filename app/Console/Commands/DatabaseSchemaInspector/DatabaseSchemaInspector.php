<?php

namespace App\Console\Commands\DatabaseSchemaInspector;

use App\Console\Commands\DatabaseSchemaInspector\PGSQL\Field;

interface DatabaseSchemaInspector
{
    /**
     * @return string[]
     */
    public function getTableNames(): array;

    /**
     * @param string $tableName
     * @return Field[]
     */
    public function getFields(string $tableName): array;

    /**
     * @param string $tableName
     * @return array
     */
    public function getData(string $tableName): array;
}
