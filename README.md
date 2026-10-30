# Drupal agentic coding examples

Small, reviewable examples that accompany *Implementando módulos customizados no Drupal com agentes de IA*.

The sample module targets Drupal 11 and demonstrates a service registered through dependency injection, an entity query with explicit access checking, a focused PHPUnit unit test with mocks, and a local PHPCS pre-commit hook. Adapt service names, bundle names, coding standards, and test commands to the host project.

## Use the example module

Copy `agentic_examples` into `web/modules/custom/` of a Drupal 11 project. Enable it with `vendor/bin/drush en agentic_examples -y` and inspect the `agentic_examples.book_title_provider` service.

Run PHPCS using the host project's `phpcs.xml*` configuration:

```sh
vendor/bin/phpcs web/modules/custom/agentic_examples
```

Run the unit test with the host project's Drupal PHPUnit configuration. The exact config and bootstrap vary between Drupal projects; configure them before treating the test as a release gate.

To use the included hook, set `DRUPAL_PROJECT_ROOT` to the Drupal project root, then enable hooks from this repository:

```sh
git config core.hooksPath .githooks
DRUPAL_PROJECT_ROOT=/path/to/drupal git commit
```

The hook checks staged PHP files. Git hooks are local convenience checks and can be skipped or omitted; enforce required checks again in CI.

## Source and license

These examples were written for the book and are licensed under GPL-2.0-only. Drupal itself and its APIs remain subject to their own copyright and trademark terms. See `LICENSE.txt`.
