<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211009131055 extends AbstractMigration
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
        $this->addSql('CREATE TABLE tile_effects (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, effect_value INT NOT NULL, effect_target VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE tile_type');
        $this->addSql('DROP INDEX IDX_768FA904F5E9B83B ON tile');
        $this->addSql('ALTER TABLE tile ADD effects_id INT NOT NULL, DROP effect_id');
        $this->addSql('ALTER TABLE tile ADD CONSTRAINT FK_768FA904568FBDB9 FOREIGN KEY (effects_id) REFERENCES tile_effects (id)');
        $this->addSql('CREATE INDEX IDX_768FA904568FBDB9 ON tile (effects_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tile DROP FOREIGN KEY FK_768FA904568FBDB9');
        $this->addSql('CREATE TABLE tile_type (id INT AUTO_INCREMENT NOT NULL, effect_value INT NOT NULL, effect_target VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE tile_effects');
        $this->addSql('DROP INDEX IDX_768FA904568FBDB9 ON tile');
        $this->addSql('ALTER TABLE tile ADD effect_id INT DEFAULT NULL, DROP effects_id');
        $this->addSql('ALTER TABLE tile ADD CONSTRAINT FK_768FA904F5E9B83B FOREIGN KEY (effect_id) REFERENCES tile_type (id)');
        $this->addSql('CREATE INDEX IDX_768FA904F5E9B83B ON tile (effect_id)');
    }
}
