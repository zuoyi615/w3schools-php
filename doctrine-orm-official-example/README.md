# the official example of Doctrine ORM

```bash
php bin/doctrine.php orm:schema-tool:create
php bin/doctrine.php orm:schema-tool:drop --force
php bin/doctrine.php orm:schema-tool:update --force --dump-sql --complete

# insert products into the database
php create_product.php ORM
php create_product.php DBAL
```
