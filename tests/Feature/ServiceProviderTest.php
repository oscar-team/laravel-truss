<?php

declare(strict_types=1);

use OscarMobility\Truss\TrussServiceProvider;

it('boots and registers the Truss service provider', function () {
    expect(app()->getProvider(TrussServiceProvider::class))
        ->toBeInstanceOf(TrussServiceProvider::class);
});
