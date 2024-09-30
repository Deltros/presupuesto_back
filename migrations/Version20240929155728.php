<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240929155728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gasto (id INT AUTO_INCREMENT NOT NULL, tarjeta_id INT NOT NULL, gasto_tipo_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, valor INT NOT NULL, fecha_gasto DATE NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_AE43DA14D8720997 (tarjeta_id), INDEX IDX_AE43DA146CF6B5FE (gasto_tipo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gasto ADD CONSTRAINT FK_AE43DA14D8720997 FOREIGN KEY (tarjeta_id) REFERENCES tarjeta (id)');
        $this->addSql('ALTER TABLE gasto ADD CONSTRAINT FK_AE43DA146CF6B5FE FOREIGN KEY (gasto_tipo_id) REFERENCES gasto_tipo (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE gasto DROP FOREIGN KEY FK_AE43DA14D8720997');
        $this->addSql('ALTER TABLE gasto DROP FOREIGN KEY FK_AE43DA146CF6B5FE');
        $this->addSql('DROP TABLE gasto');
    }
}
