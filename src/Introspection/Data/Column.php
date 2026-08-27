<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Introspection\Data;

/**
 * A single column. `type` is the native full type exactly as the database
 * reports it (e.g. "varchar(255)", "bigint unsigned") — never a reverse-mapped
 * Laravel migration verb. `default` is part of the table structure, not row data.
 */
final class Column
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly bool $nullable,
        public readonly ?string $default,
    ) {}
}
