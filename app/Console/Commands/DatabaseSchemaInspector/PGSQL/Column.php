<?php

namespace App\Console\Commands\DatabaseSchemaInspector\PGSQL;

readonly class Column
{
    public string $column_name;
    public ?string $column_default;
    public string $is_nullable;
    public string $data_type;
    public bool $is_foreign_key;
    public ?string $referenced_table_name;
    public ?string $referenced_owner_key;

    public function __construct(object $field)
    {
        // TODO return exception if field is not an object
        $this->column_name = $field->column_name;
        $this->column_default = $field->column_default ?? null;
        $this->is_nullable = $field->is_nullable;
        $this->data_type = $field->data_type;
        $this->is_foreign_key = $field->is_foreign_key ?? false;
        $this->referenced_table_name = $field->referenced_table_name ?? null;
        $this->referenced_owner_key = $field->referenced_owner_key ?? null;
    }
}
