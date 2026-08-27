<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Introspection\Data;

/**
 * A table and its structure. `primaryKey` is the hoisted primary key (empty when
 * the table has none); it is NOT repeated in `indexes`, which holds only
 * non-primary indexes. Per-column PK/FK badges are derived at render time from
 * `primaryKey` and `foreignKeys`, not stored on columns.
 */
final class Table
{
    /**
     * @param  list<Column>  $columns
     * @param  list<string>  $primaryKey
     * @param  list<Index>  $indexes
     * @param  list<ForeignKey>  $foreignKeys
     */
    public function __construct(
        public readonly string $name,
        public readonly array $columns,
        public readonly array $primaryKey,
        public readonly array $indexes,
        public readonly array $foreignKeys,
    ) {}
}
