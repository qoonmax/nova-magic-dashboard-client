<?php

namespace App\Console\Commands\DatabaseSchemaInspector;

use App\Console\Commands\DatabaseSchemaInspector\PGSQL\PGSQLSchemaInspector;
use App\Console\Commands\Exceptions\DriverNotSupported;

class SchemaInspectorFactory
{
    /**
     * @throws DriverNotSupported
     */
    public static function make(string $driver): DatabaseSchemaInspector
    {
        return match ($driver) {
            'pgsql' => new PGSQLSchemaInspector(),
            default => throw new DriverNotSupported('Database driver not supported.'),
        };
    }
}
