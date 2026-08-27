<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Introspection\Data;

/**
 * A foreign key. Both the local `columns` and the referenced `referencesColumns`
 * are arrays so composite foreign keys are first-class. `onUpdate`/`onDelete`
 * carry the referential actions (structure, not data) for display.
 */
final class ForeignKey
{
    /**
     * @param  list<string>  $columns
     * @param  list<string>  $referencesColumns
     */
    public function __construct(
        public readonly string $name,
        public readonly array $columns,
        public readonly string $referencesTable,
        public readonly array $referencesColumns,
        public readonly ?string $onUpdate,
        public readonly ?string $onDelete,
    ) {}
}
