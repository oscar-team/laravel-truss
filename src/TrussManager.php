<?php

declare(strict_types=1);

namespace OscarMobility\Truss;

use OscarMobility\Truss\Cache\SchemaCacheRepository;
use OscarMobility\Truss\Export\Contracts\CommentReader;
use OscarMobility\Truss\Export\ExportBuilder;
use OscarMobility\Truss\Export\SchemaExporter;

/**
 * The entry point behind the `Truss` facade. Hands out a fresh, immutable
 * ExportBuilder for the fluent export API (`Truss::snapshot()->compact()
 * ->toDbml()`), wired with the same collaborators the command and route use.
 */
final class TrussManager
{
    public function __construct(
        private readonly SchemaCacheRepository $cache,
        private readonly SchemaExporter $exporter,
        private readonly CommentReader $commentReader,
    ) {}

    public function snapshot(): ExportBuilder
    {
        return new ExportBuilder($this->cache, $this->exporter, $this->commentReader);
    }
}
