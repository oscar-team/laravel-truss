<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Doctor\Rules\Integrity;

use OscarMobility\Truss\Doctor\Category;
use OscarMobility\Truss\Doctor\Confidence;
use OscarMobility\Truss\Doctor\Contracts\Rule;
use OscarMobility\Truss\Doctor\Finding;
use OscarMobility\Truss\Doctor\Severity;

/**
 * TRUSS-INT-001: a table with no primary key. Without one, rows cannot be
 * addressed reliably, replication and many tools struggle, and Eloquent cannot
 * identify a model. A composite primary key counts. Visible from structure alone.
 */
final class MissingPrimaryKey implements Rule
{
    public function code(): string
    {
        return 'TRUSS-INT-001';
    }

    public function category(): Category
    {
        return Category::Integrity;
    }

    public function confidence(): Confidence
    {
        return Confidence::High;
    }

    public function defaultSeverity(): Severity
    {
        return Severity::Error;
    }

    public function title(): string
    {
        return 'Table without a primary key';
    }

    public function check(array $snapshot, string $connection): iterable
    {
        foreach ($snapshot['tables'] ?? [] as $table) {
            if (($table['primary_key'] ?? []) !== []) {
                continue;
            }

            yield new Finding(
                code: $this->code(),
                severity: $this->defaultSeverity(),
                connection: $connection,
                table: $table['name'],
                column: null,
                message: "Table \"{$table['name']}\" has no primary key.",
                hint: 'A primary key uniquely identifies each row. Without one, updates and deletes are unreliable, replication and many tools struggle, and Eloquent cannot address a model.',
                suggestion: null,
            );
        }
    }
}
