<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220524113858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payement ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A788582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B20A788582EA2E54 ON payement (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A788582EA2E54');
        $this->addSql('DROP INDEX UNIQ_B20A788582EA2E54 ON payement');
        $this->addSql('ALTER TABLE payement DROP commande_id');
    }
}
