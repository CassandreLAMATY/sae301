<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110142847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cards (crd_id INT AUTO_INCREMENT NOT NULL, crd_created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', crd_type VARCHAR(20) NOT NULL, crd_title VARCHAR(255) NOT NULL, crd_desc VARCHAR(255) DEFAULT NULL, crd_subject INT DEFAULT NULL, crd_from VARCHAR(255) DEFAULT NULL, crd_to DATETIME NOT NULL, PRIMARY KEY(crd_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (usr_id INT AUTO_INCREMENT NOT NULL, usr_mail VARCHAR(100) NOT NULL, usr_pwd VARCHAR(50) NOT NULL, usr_role VARCHAR(20) NOT NULL, usr_name VARCHAR(50) NOT NULL, usr_firstname VARCHAR(50) NOT NULL, usr_tp VARCHAR(1) DEFAULT NULL, usr_banned TINYINT(1) NOT NULL, PRIMARY KEY(usr_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cards');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
