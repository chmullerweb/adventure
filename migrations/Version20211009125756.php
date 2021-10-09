<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211009125756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tile DROP FOREIGN KEY FK_768FA904F5E9B83B');
        $this->addSql('DROP TABLE tile_effect');
        $this->addSql('DROP TABLE tile_type');
        $this->addSql('DROP INDEX IDX_768FA904F5E9B83B ON tile');
        $this->addSql('ALTER TABLE tile DROP effect_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tile_effect (id INT AUTO_INCREMENT NOT NULL, effect_value INT NOT NULL, effect_target VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tile_type (id INT AUTO_INCREMENT NOT NULL, effect_value INT NOT NULL, effect_target VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tile ADD effect_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tile ADD CONSTRAINT FK_768FA904F5E9B83B FOREIGN KEY (effect_id) REFERENCES tile_type (id)');
        $this->addSql('CREATE INDEX IDX_768FA904F5E9B83B ON tile (effect_id)');
    }
}
