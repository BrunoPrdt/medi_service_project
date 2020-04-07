<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190926155326 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, zip_code INT NOT NULL, city VARCHAR(255) NOT NULL, phone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles CHANGE description description VARCHAR(255) DEFAULT NULL, ADD name VARCHAR(255) DEFAULT NULL, ADD material_state VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD availability VARCHAR(255) NOT NULL, ADD electric VARCHAR(255) DEFAULT NULL, ADD manual VARCHAR(255) DEFAULT NULL, ADD ultra_light VARCHAR(255) DEFAULT NULL, ADD kid VARCHAR(255) DEFAULT NULL, ADD comfort VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prospects ADD mail VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservations CHANGE reservation_date reservation_date DATE DEFAULT NULL, ADD availability_date DATE DEFAULT NULL, ADD return_comment VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE stock');
        $this->addSql('ALTER TABLE articles DROP name, DROP material_state, DROP type, DROP availability, DROP electric, DROP manual, DROP ultra_light, DROP kid, DROP comfort');
        $this->addSql('ALTER TABLE prospects DROP mail');
        $this->addSql('ALTER TABLE reservations DROP availability_date, DROP return_comment');
    }
}
