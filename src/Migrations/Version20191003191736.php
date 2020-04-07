<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191003191736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles DROP electric, DROP manual, DROP ultra_light, DROP kid, DROP comfort');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA2397294869C');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239D182060A');
        $this->addSql('DROP INDEX IDX_4DA2397294869C ON reservations');
        $this->addSql('DROP INDEX IDX_4DA239A76ED395 ON reservations');
        $this->addSql('DROP INDEX IDX_4DA239D182060A ON reservations');
        $this->addSql('ALTER TABLE reservations DROP user_id, DROP article_id, DROP prospect_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE articles ADD electric VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD manual VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD ultra_light VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD kid VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD comfort VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE reservations ADD user_id INT DEFAULT NULL, ADD article_id INT DEFAULT NULL, ADD prospect_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2397294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239D182060A FOREIGN KEY (prospect_id) REFERENCES prospects (id)');
        $this->addSql('CREATE INDEX IDX_4DA2397294869C ON reservations (article_id)');
        $this->addSql('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
        $this->addSql('CREATE INDEX IDX_4DA239D182060A ON reservations (prospect_id)');
    }
}
