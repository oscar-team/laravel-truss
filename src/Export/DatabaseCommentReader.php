<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Export;

use OscarMobility\Truss\Export\Contracts\CommentReader;
use OscarMobility\Truss\Support\WithoutTablePrefix;
use Illuminate\Support\Facades\Schema;

/**
 * Reads native table and column comments through Laravel's schema introspection.
 * MySQL/MariaDB and Postgres expose comments as part of getTables()/getColumns();
 * SQLite and SQL Server have none, so those drivers return an empty map.
 *
 * Structure only: a comment is part of the CREATE TABLE definition, never row
 * data. This is the one DB-touching collaborator behind the Annotator.
 */
final class DatabaseCommentReader implements CommentReader
{
    /**
     * Drivers whose schema comments Laravel introspection surfaces.
     */
    private const SUPPORTED = ['mysql', 'mariadb', 'pgsql'];

    public function read(?string $connection = null): array
    {
        $builder = Schema::connection($connection);

        if (! in_array($builder->getConnection()->getDriverName(), self::SUPPORTED, true)) {
            return [];
        }

        $comments = [];

        // Read in real database names, with the connection's table prefix
        // suspended. getTables() reports names exactly as stored, prefix
        // included, while getColumns() prepends the prefix again, so on a
        // prefixed connection every column comment would silently go missing
        // (issue #46). Mirrors SnapshotBuilder::introspect().
        // Laravel 10: bare getTables() (no schema argument) and WithoutTablePrefix.
        WithoutTablePrefix::run($builder->getConnection(), function () use ($builder, &$comments): void {
            foreach ($builder->getTables() as $table) {
                $name = is_array($table) ? (string) $table['name'] : (string) $table;
                $schema = is_array($table) ? ($table['schema'] ?? $table['schema_name'] ?? null) : null;

                if (str_starts_with($name, 'sqlite_')) {
                    continue;
                }

                if (is_string($schema) && $schema !== '' && ! in_array(strtolower($schema), ['main', 'temp'], true)) {
                    continue;
                }

                if (is_array($table) && $this->present($table['comment'] ?? null)) {
                    $comments[$name] = (string) $table['comment'];
                }

                foreach ($builder->getColumns($name) as $column) {
                    if ($this->present($column['comment'] ?? null)) {
                        $comments["{$name}.{$column['name']}"] = (string) $column['comment'];
                    }
                }
            }
        });

        return $comments;
    }

    private function present(mixed $comment): bool
    {
        return $comment !== null && trim((string) $comment) !== '';
    }
}
