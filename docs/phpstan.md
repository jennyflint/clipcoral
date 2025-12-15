# Using PhpStan

### 1.
 - Create new file  `phpstan.neon` based on `phpstan.dist.neon`

### 2. Generate cache
 `php bin/console cache:warmup`

### 1. Run phpstan
 `vendor/bin/phpstan analyse`
 - OR
 `vendor/bin/phpstan analyse --memory-limit=2G`