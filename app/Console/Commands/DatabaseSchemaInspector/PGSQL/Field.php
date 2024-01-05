<?php

namespace App\Console\Commands\DatabaseSchemaInspector\PGSQL;

readonly class Field
{
    public ?string $tableCatalog;
    public ?string $tableSchema;
    public ?string $tableName;
    public ?string $columnName;
    public ?int $ordinalPosition;
    public ?string $columnDefault;
    public ?string $isNullable;
    public ?string $dataType;
    public ?int $characterMaximumLength;
    public ?int $characterOctetLength;
    public ?int $numericPrecision;
    public ?int $numericPrecisionRadix;
    public ?int $numericScale;
    public ?int $datetimePrecision;
    public ?string $intervalType;
    public ?int $intervalPrecision;
    public ?string $characterSetCatalog;
    public ?string $characterSetSchema;
    public ?string $characterSetName;
    public ?string $collationCatalog;
    public ?string $collationSchema;
    public ?string $collationName;
    public ?string $domainCatalog;
    public ?string $domainSchema;
    public ?string $domainName;
    public ?string $udtCatalog;
    public ?string $udtSchema;
    public ?string $udtName;
    public ?string $scopeCatalog;
    public ?string $scopeSchema;
    public ?string $scopeName;
    public ?int $maximumCardinality;
    public ?string $dtdIdentifier;
    public ?string $isSelfReferencing;
    public ?string $isIdentity;
    public ?string $identityGeneration;
    public ?string $identityStart;
    public ?string $identityIncrement;
    public ?string $identityMaximum;
    public ?string $identityMinimum;
    public ?string $identityCycle;
    public ?string $isGenerated;
    public ?string $generationExpression;
    public ?string $isUpdatable;

    public function __construct(object $field)
    {
        $this->tableCatalog = $field->table_catalog ?? null;
        $this->tableSchema = $field->table_schema ?? null;
        $this->tableName = $field->table_name ?? null;
        $this->columnName = $field->column_name ?? null;
        $this->ordinalPosition = $field->ordinal_position ?? null;
        $this->columnDefault = $field->column_default ?? null;
        $this->isNullable = $field->is_nullable ?? null;
        $this->dataType = $field->data_type ?? null;
        $this->characterMaximumLength = $field->character_maximum_length ?? null;
        $this->characterOctetLength = $field->character_octet_length ?? null;
        $this->numericPrecision = $field->numeric_precision ?? null;
        $this->numericPrecisionRadix = $field->numeric_precision_radix ?? null;
        $this->numericScale = $field->numeric_scale ?? null;
        $this->datetimePrecision = $field->datetime_precision ?? null;
        $this->intervalType = $field->interval_type ?? null;
        $this->intervalPrecision = $field->interval_precision ?? null;
        $this->characterSetCatalog = $field->character_set_catalog ?? null;
        $this->characterSetSchema = $field->character_set_schema ?? null;
        $this->characterSetName = $field->character_set_name ?? null;
        $this->collationCatalog = $field->collation_catalog ?? null;
        $this->collationSchema = $field->collation_schema ?? null;
        $this->collationName = $field->collation_name ?? null;
        $this->domainCatalog = $field->domain_catalog ?? null;
        $this->domainSchema = $field->domain_schema ?? null;
        $this->domainName = $field->domain_name ?? null;
        $this->udtCatalog = $field->udt_catalog ?? null;
        $this->udtSchema = $field->udt_schema ?? null;
        $this->udtName = $field->udt_name ?? null;
        $this->scopeCatalog = $field->scope_catalog ?? null;
        $this->scopeSchema = $field->scope_schema ?? null;
        $this->scopeName = $field->scope_name ?? null;
        $this->maximumCardinality = $field->maximum_cardinality ?? null;
        $this->dtdIdentifier = $field->dtd_identifier ?? null;
        $this->isSelfReferencing = $field->is_self_referencing ?? null;
        $this->isIdentity = $field->is_identity ?? null;
        $this->identityGeneration = $field->identity_generation ?? null;
        $this->identityStart = $field->identity_start ?? null;
        $this->identityIncrement = $field->identity_increment ?? null;
        $this->identityMaximum = $field->identity_maximum ?? null;
        $this->identityMinimum = $field->identity_minimum ?? null;
        $this->identityCycle = $field->identity_cycle ?? null;
        $this->isGenerated = $field->is_generated ?? null;
        $this->generationExpression = $field->generation_expression ?? null;
        $this->isUpdatable = $field->is_updatable ?? null;
    }
}
