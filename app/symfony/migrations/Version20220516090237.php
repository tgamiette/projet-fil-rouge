<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516090237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_user CHANGE customer_id customer_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE unit unit VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE products_order CHANGE status status VARCHAR(255) NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE quantity quantity DOUBLE PRECISION NOT NULL, CHANGE prix_u prix_u DOUBLE PRECISION NOT NULL, CHANGE unit unit INT NOT NULL, CHANGE total total INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order_user` CHANGE customer_id customer_id INT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE unit unit VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE products_order CHANGE status status INT DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE quantity quantity DOUBLE PRECISION DEFAULT NULL, CHANGE prix_u prix_u DOUBLE PRECISION DEFAULT NULL, CHANGE unit unit INT DEFAULT NULL, CHANGE total total INT DEFAULT NULL');
    }
}
