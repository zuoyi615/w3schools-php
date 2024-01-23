<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migrate `users` table manually
 */
final class Version20240122085249 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // CREATE TABLE IF EXISTS `users`();
        $users = $schema->createTable('users');
        $users->addColumn('id', Types::INTEGER)->setAutoincrement(true);
        $users->addColumn('user_name', Types::STRING);
        $users->addColumn('created_at', Types::DATETIME_MUTABLE);
        $users->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        // DROP TABLE IF EXISTS `users`();
        $schema->dropTable('users');
    }

}
