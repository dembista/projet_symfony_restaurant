<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509173545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD burger_id INT DEFAULT NULL, ADD complement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F17CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F40D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F17CE5090 ON image (burger_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F40D9D0AA ON image (complement_id)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F17CE5090');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F40D9D0AA');
        $this->addSql('DROP INDEX IDX_C53D045F17CE5090 ON image');
        $this->addSql('DROP INDEX IDX_C53D045F40D9D0AA ON image');
        $this->addSql('ALTER TABLE image DROP burger_id, DROP complement_id');
        $this->addSql('ALTER TABLE user DROP is_verified');
    }
}
