<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201025912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Category (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, last_modified_at DATETIME NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Merchant (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, last_modified_at DATETIME NOT NULL, created_at DATETIME NOT NULL, subCategory_id INT DEFAULT NULL, INDEX IDX_8DDD47B7DB5A7180 (subCategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SubCategory (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name LONGTEXT NOT NULL, last_modified_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_723649C912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Merchant ADD CONSTRAINT FK_8DDD47B7DB5A7180 FOREIGN KEY (subCategory_id) REFERENCES SubCategory (id)');
        $this->addSql('ALTER TABLE SubCategory ADD CONSTRAINT FK_723649C912469DE2 FOREIGN KEY (category_id) REFERENCES Category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Merchant DROP FOREIGN KEY FK_8DDD47B7DB5A7180');
        $this->addSql('ALTER TABLE SubCategory DROP FOREIGN KEY FK_723649C912469DE2');
        $this->addSql('DROP TABLE Category');
        $this->addSql('DROP TABLE Merchant');
        $this->addSql('DROP TABLE SubCategory');
    }
}
