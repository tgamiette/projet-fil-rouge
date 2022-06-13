<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606150807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_C53D045FA76ED395 (user_id), INDEX IDX_C53D045F4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, INDEX IDX_14D431324584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT FK_14D431324584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_user DROP FOREIGN KEY FK_C062EC5E316F5B21');
        $this->addSql('DROP INDEX IDX_C062EC5E316F5B21 ON order_user');
        $this->addSql('ALTER TABLE order_user DROP order_seller_id');
        $this->addSql('ALTER TABLE product DROP image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('ALTER TABLE `order_user` ADD order_seller_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order_user` ADD CONSTRAINT FK_C062EC5E316F5B21 FOREIGN KEY (order_seller_id) REFERENCES order_seller (id)');
        $this->addSql('CREATE INDEX IDX_C062EC5E316F5B21 ON `order_user` (order_seller_id)');
        $this->addSql('ALTER TABLE product ADD image VARCHAR(255) DEFAULT NULL');
    }
}
