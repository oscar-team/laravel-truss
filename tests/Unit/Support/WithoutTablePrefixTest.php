<?php

declare(strict_types=1);

use OscarMobility\Truss\Support\WithoutTablePrefix;
use Illuminate\Support\Facades\DB;

it('runs the callback with the table prefix cleared and restores it', function () {
    $connection = DB::connection('testing');
    $connection->setTablePrefix('portal_');

    $seen = WithoutTablePrefix::run($connection, fn (): string => $connection->getTablePrefix());

    expect($seen)->toBe('')
        ->and($connection->getTablePrefix())->toBe('portal_');

    $connection->setTablePrefix('');
});

it('leaves an empty prefix untouched', function () {
    $connection = DB::connection('testing');
    $connection->setTablePrefix('');

    $seen = WithoutTablePrefix::run($connection, fn (): string => $connection->getTablePrefix());

    expect($seen)->toBe('')
        ->and($connection->getTablePrefix())->toBe('');
});

it('restores the prefix when the callback throws', function () {
    $connection = DB::connection('testing');
    $connection->setTablePrefix('portal_');

    try {
        WithoutTablePrefix::run($connection, function (): void {
            throw new RuntimeException('boom');
        });
    } catch (RuntimeException) {
        // expected
    }

    expect($connection->getTablePrefix())->toBe('portal_');

    $connection->setTablePrefix('');
});
