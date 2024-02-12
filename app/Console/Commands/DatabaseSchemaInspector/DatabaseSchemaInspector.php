<?php

namespace App\Console\Commands\DatabaseSchemaInspector;

use App\Console\Commands\DatabaseSchemaInspector\PGSQL\Column;

interface DatabaseSchemaInspector
{
    /**
     * @return string[]
     */
    public function getTableNames(): array;

    /**
     * @param string $tableName
     * @return Column[]
     */
    public function getFields(string $tableName): array;

    /**
     * @param string $tableName
     * @return array
     */
    public function getData(string $tableName): array;
}
