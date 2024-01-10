<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110160356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_cards DROP FOREIGN KEY FK_E3B5FCB4E1B71FF4');
        $this->addSql('ALTER TABLE users_cards DROP FOREIGN KEY FK_E3B5FCB4F6C98D65');
        $this->addSql('DROP INDEX IDX_E3B5FCB4E1B71FF4 ON users_cards');
        $this->addSql('DROP INDEX IDX_E3B5FCB4F6C98D65 ON users_cards');
        $this->addSql('ALTER TABLE users_cards ADD uc_usr_id INT DEFAULT NULL, ADD uc_crd_id INT DEFAULT NULL, DROP uc_usr_id_id, DROP uc_crd_id_id');
        $this->addSql('ALTER TABLE users_cards ADD CONSTRAINT FK_E3B5FCB46A6FDE6A FOREIGN KEY (uc_usr_id) REFERENCES users (usr_id)');
        $this->addSql('ALTER TABLE users_cards ADD CONSTRAINT FK_E3B5FCB4F7F21E1F FOREIGN KEY (uc_crd_id) REFERENCES cards (crd_id)');
        $this->addSql('CREATE INDEX IDX_E3B5FCB46A6FDE6A ON users_cards (uc_usr_id)');
        $this->addSql('CREATE INDEX IDX_E3B5FCB4F7F21E1F ON users_cards (uc_crd_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_cards DROP FOREIGN KEY FK_E3B5FCB46A6FDE6A');
        $this->addSql('ALTER TABLE users_cards DROP FOREIGN KEY FK_E3B5FCB4F7F21E1F');
        $this->addSql('DROP INDEX IDX_E3B5FCB46A6FDE6A ON users_cards');
        $this->addSql('DROP INDEX IDX_E3B5FCB4F7F21E1F ON users_cards');
        $this->addSql('ALTER TABLE users_cards ADD uc_usr_id_id INT DEFAULT NULL, ADD uc_crd_id_id INT DEFAULT NULL, DROP uc_usr_id, DROP uc_crd_id');
        $this->addSql('ALTER TABLE users_cards ADD CONSTRAINT FK_E3B5FCB4E1B71FF4 FOREIGN KEY (uc_usr_id_id) REFERENCES users (usr_id)');
        $this->addSql('ALTER TABLE users_cards ADD CONSTRAINT FK_E3B5FCB4F6C98D65 FOREIGN KEY (uc_crd_id_id) REFERENCES cards (crd_id)');
        $this->addSql('CREATE INDEX IDX_E3B5FCB4E1B71FF4 ON users_cards (uc_usr_id_id)');
        $this->addSql('CREATE INDEX IDX_E3B5FCB4F6C98D65 ON users_cards (uc_crd_id_id)');
    }
}
