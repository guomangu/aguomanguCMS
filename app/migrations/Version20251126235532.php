<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251126235532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE art (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE com_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, state INTEGER NOT NULL, message CLOB NOT NULL COLLATE "utf8mb4_unicode_ci", lft INTEGER NOT NULL, rgt INTEGER NOT NULL, depth INTEGER NOT NULL, created DATETIME NOT NULL, changed DATETIME NOT NULL, idCommentsParent INTEGER DEFAULT NULL, threadId INTEGER DEFAULT NULL, idUsersCreator INTEGER DEFAULT NULL, idUsersChanger INTEGER DEFAULT NULL, CONSTRAINT FK_AA6F14A324308710 FOREIGN KEY (idCommentsParent) REFERENCES com_comment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA6F14A34579B4E1 FOREIGN KEY (threadId) REFERENCES com_threads (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA6F14A3DBF11E1D FOREIGN KEY (idUsersCreator) REFERENCES se_users (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA6F14A330D07CD5 FOREIGN KEY (idUsersChanger) REFERENCES se_users (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AA6F14A324308710 ON com_comment (idCommentsParent)');
        $this->addSql('CREATE INDEX IDX_AA6F14A34579B4E1 ON com_comment (threadId)');
        $this->addSql('CREATE INDEX IDX_AA6F14A3DBF11E1D ON com_comment (idUsersCreator)');
        $this->addSql('CREATE INDEX IDX_AA6F14A330D07CD5 ON com_comment (idUsersChanger)');
        $this->addSql('CREATE TABLE com_threads (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(64) NOT NULL, entityId VARCHAR(64) NOT NULL, title VARCHAR(255) DEFAULT NULL, commentCount INTEGER NOT NULL, created DATETIME NOT NULL, changed DATETIME NOT NULL, idUsersCreator INTEGER DEFAULT NULL, idUsersChanger INTEGER DEFAULT NULL, CONSTRAINT FK_51957B12DBF11E1D FOREIGN KEY (idUsersCreator) REFERENCES se_users (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_51957B1230D07CD5 FOREIGN KEY (idUsersChanger) REFERENCES se_users (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_51957B12DBF11E1D ON com_threads (idUsersCreator)');
        $this->addSql('CREATE INDEX IDX_51957B1230D07CD5 ON com_threads (idUsersChanger)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51957B128CDE5729F62829FC ON com_threads (type, entityId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE art');
        $this->addSql('DROP TABLE com_comment');
        $this->addSql('DROP TABLE com_threads');
    }
}
