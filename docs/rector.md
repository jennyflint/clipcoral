# Using Rector

### Description Commands

- Dry Run `vendor/bin/rector process --dry-run`
- Dry run inside certain folder `vendor/bin/rector process src/Entity --dry-run`
- Fix Code `vendor/bin/rector process`
- Fix error memory limit `php -d memory_limit=-1 vendor/bin/rector process --dry-run`