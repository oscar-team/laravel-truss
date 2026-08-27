<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Support;

use Illuminate\Database\Connection;

/**
 * Laravel 12 has Connection::withoutTablePrefix(). Laravel 10 does not.
 * Clearing the prefix for one pass avoids looking up "prefix_prefix_users".
 */
final class WithoutTablePrefix
{
    /**
     * @template T
     *
     * @param  callable(): T  $callback
     * @return T
     */
    public static function run(Connection $connection, callable $callback): mixed
    {
        if (method_exists($connection, 'withoutTablePrefix')) {
            return $connection->withoutTablePrefix($callback);
        }

        $prefix = $connection->getTablePrefix();

        if ($prefix === '') {
            return $callback();
        }

        $connection->setTablePrefix('');

        try {
            return $callback();
        } finally {
            $connection->setTablePrefix($prefix);
        }
    }
}
