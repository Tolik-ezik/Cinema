<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260812144614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT fk_e00ceddef8a81357');
        $this->addSql('DROP INDEX idx_e00ceddef8a81357');
        $this->addSql('ALTER TABLE booking RENAME COLUMN owmer_id TO owner_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_E00CEDDE7E3C61F9 ON booking (owner_id)');
        $this->addSql('ALTER TABLE movie DROP is_active');
        $this->addSql('ALTER TABLE ticket RENAME COLUMN prise TO price');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE7E3C61F9');
        $this->addSql('DROP INDEX IDX_E00CEDDE7E3C61F9');
        $this->addSql('ALTER TABLE booking RENAME COLUMN owner_id TO owmer_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT fk_e00ceddef8a81357 FOREIGN KEY (owmer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e00ceddef8a81357 ON booking (owmer_id)');
        $this->addSql('ALTER TABLE movie ADD is_active BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE ticket RENAME COLUMN price TO prise');
    }
}
