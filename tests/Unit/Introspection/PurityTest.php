<?php

declare(strict_types=1);

// Enforces the rule in src/Introspection/CLAUDE.md: this layer knows only about
// the database. It must never reach into the web, view, cache, or render stack.
// Database access (connections, the schema builder) is expected and allowed.

arch('the introspection layer has no HTTP, view, cache or routing dependencies')
    ->expect('OscarMobility\Truss\Introspection')
    ->not->toUse([
        'Illuminate\Http',
        'Illuminate\Routing',
        'Illuminate\View',
        'Illuminate\Cache',
        'Illuminate\Support\Facades\Cache',
        'Illuminate\Support\Facades\View',
        'Illuminate\Support\Facades\Route',
        'Illuminate\Support\Facades\Blade',
    ]);

arch('the introspection value objects are final')
    ->expect('OscarMobility\Truss\Introspection\Data')
    ->toBeFinal();

it('exposes only readonly properties on introspection value objects', function () {
    $files = glob(dirname(__DIR__, 3).'/src/Introspection/Data/*.php');

    expect($files)->not->toBeEmpty();

    foreach ($files as $file) {
        $class = 'OscarMobility\\Truss\\Introspection\\Data\\'.basename($file, '.php');
        $properties = (new ReflectionClass($class))->getProperties();

        expect($properties)->not->toBeEmpty();

        foreach ($properties as $property) {
            expect($property->isReadOnly())->toBeTrue();
        }
    }
});
