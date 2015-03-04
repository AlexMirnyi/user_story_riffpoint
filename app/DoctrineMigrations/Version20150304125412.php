<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150304125412 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE main_author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE main_book (id INT AUTO_INCREMENT NOT NULL, genre_id INT DEFAULT NULL, publisher_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2B569153CC1CF4E6 (isbn), INDEX IDX_2B5691534296D31F (genre_id), INDEX IDX_2B56915340C86FCE (publisher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE author_book (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_2F0A2BEE16A2B381 (book_id), INDEX IDX_2F0A2BEEF675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE main_book_genre (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE main_publisher (id INT AUTO_INCREMENT NOT NULL, published VARCHAR(255) DEFAULT NULL, edition VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE main_book ADD CONSTRAINT FK_2B5691534296D31F FOREIGN KEY (genre_id) REFERENCES main_book_genre (id)');
        $this->addSql('ALTER TABLE main_book ADD CONSTRAINT FK_2B56915340C86FCE FOREIGN KEY (publisher_id) REFERENCES main_publisher (id)');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEE16A2B381 FOREIGN KEY (book_id) REFERENCES main_book (id)');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEEF675F31B FOREIGN KEY (author_id) REFERENCES main_author (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author_book DROP FOREIGN KEY FK_2F0A2BEEF675F31B');
        $this->addSql('ALTER TABLE author_book DROP FOREIGN KEY FK_2F0A2BEE16A2B381');
        $this->addSql('ALTER TABLE main_book DROP FOREIGN KEY FK_2B5691534296D31F');
        $this->addSql('ALTER TABLE main_book DROP FOREIGN KEY FK_2B56915340C86FCE');
        $this->addSql('DROP TABLE main_author');
        $this->addSql('DROP TABLE main_book');
        $this->addSql('DROP TABLE author_book');
        $this->addSql('DROP TABLE main_book_genre');
        $this->addSql('DROP TABLE main_publisher');
    }
}
