<?php

declare(strict_types=1);

namespace OscarMobility\Truss\Facades;

use OscarMobility\Truss\TrussManager;
use Illuminate\Support\Facades\Facade;

/**
 * The public Truss facade.
 *
 * @method static \OscarMobility\Truss\Export\ExportBuilder snapshot()
 *
 * @see TrussManager
 */
class Truss extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TrussManager::class;
    }
}
