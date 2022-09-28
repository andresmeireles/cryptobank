<?php

declare(strict_types=1);

namespace Cryptocli\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927142644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_token DROP INDEX UNIQ_9315F04EA76ED395, ADD INDEX IDX_9315F04EA76ED395 (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_token DROP INDEX IDX_9315F04EA76ED395, ADD UNIQUE INDEX UNIQ_9315F04EA76ED395 (user_id)');
    }
}
