<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Introspection\Data;

/**
 * A non-primary index. The primary key lives on {@see Table::$primaryKey}, not
 * here. `columns` is always an array so composite indexes are first-class.
 */
final class Index
{
    /**
     * @param  list<string>  $columns
     */
    public function __construct(
        public readonly string $name,
        public readonly array $columns,
        public readonly bool $unique,
    ) {}
}
