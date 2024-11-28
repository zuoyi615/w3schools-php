# Doctrine Migration

Installation

```bash
composer require "doctrine/migrations"
```

create `migrations.php` and `cli-config.php` for ` ./vendor/bin/doctrine-migrations generate`

Migration

```bash
./vendor/bin/doctrine-migrations generate
./vendor/bin/doctrine-migrations diff
./vendor/bin/doctrine-migrations status
./vendor/bin/doctrine-migrations migrate
./vendor/bin/doctrine-migrations first
```
