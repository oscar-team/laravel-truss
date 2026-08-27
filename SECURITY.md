# Security Policy

## Supported versions

The latest released `1.x` line receives security fixes.

## Reporting a vulnerability

Please do not open a public issue for security problems.

- **This Laravel 10 port** (`oscar-team/laravel-truss`): report to the Oscar Mobility
  maintainers of this tree.
- **Upstream Laravel 12+ Truss** (`albertoarena/laravel-truss`): email Alberto Arena at
  hello@albertoarena.it.

Include a description of the issue and a way to reproduce it. You can expect an
acknowledgement within a few days, and a fix or mitigation plan once the report is confirmed.

## Scope

Truss exposes database structure only (tables, columns, indexes, foreign keys) and never queries or
renders row data. Access is protected by the fixed `viewTruss` gate, which is consulted in every
non-local environment and returns 404 on denial. Reports about structure leaking as data, the gate
being bypassed, or the asset route serving unintended files are all in scope.
