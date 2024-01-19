<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119163820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD usr_pp VARCHAR(100) DEFAULT NULL, DROP usr_homework_reminder, DROP usr_exam_reminder, DROP usr_new_reminder, DROP usr_modif_reminder, DROP usr_cookies');
        $this->addSql('ALTER TABLE users_cards ADD uc_reminder DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_cards DROP uc_reminder');
        $this->addSql('ALTER TABLE users ADD usr_homework_reminder TINYINT(1) NOT NULL, ADD usr_exam_reminder TINYINT(1) NOT NULL, ADD usr_new_reminder TINYINT(1) NOT NULL, ADD usr_modif_reminder TINYINT(1) NOT NULL, ADD usr_cookies TINYINT(1) NOT NULL, DROP usr_pp');
    }
}
