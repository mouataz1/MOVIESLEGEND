<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117180835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE rate');
        $this->addSql('ALTER TABLE comment ADD likes INT DEFAULT NULL, ADD dislikes INT DEFAULT NULL, CHANGE content body LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE movie ADD category_id INT DEFAULT NULL, ADD sub_category_id INT DEFAULT NULL, ADD user_id INT NOT NULL, ADD duration DOUBLE PRECISION DEFAULT NULL, ADD released_at DATE DEFAULT NULL, DROP published_at, DROP added_at, DROP country, CHANGE watchlink link VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26F12469DE2 ON movie (category_id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26FF7BFE87C ON movie (sub_category_id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26FA76ED395 ON movie (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FF7BFE87C');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, one_star INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('ALTER TABLE comment DROP likes, DROP dislikes, CHANGE body content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26F12469DE2');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FA76ED395');
        $this->addSql('DROP INDEX IDX_1D5EF26F12469DE2 ON movie');
        $this->addSql('DROP INDEX IDX_1D5EF26FF7BFE87C ON movie');
        $this->addSql('DROP INDEX IDX_1D5EF26FA76ED395 ON movie');
        $this->addSql('ALTER TABLE movie ADD published_at DATETIME DEFAULT NULL, ADD added_at DATETIME NOT NULL, ADD country VARCHAR(255) NOT NULL, DROP category_id, DROP sub_category_id, DROP user_id, DROP duration, DROP released_at, CHANGE link watchlink VARCHAR(255) DEFAULT NULL');
    }
}
