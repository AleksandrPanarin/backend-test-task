<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706113954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchases ADD payment_processor_type VARCHAR(50) NOT NULL');
        $this->addSql('COMMENT ON COLUMN purchases.payment_processor_type IS \'(DC2Type:payment_processor_type)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE purchases DROP payment_processor_type');
        $this->addSql('ALTER TABLE purchases ALTER coupon_code DROP NOT NULL');
        $this->addSql('ALTER TABLE purchases ALTER coupon_type DROP NOT NULL');
        $this->addSql('ALTER TABLE purchases ALTER coupon_discount DROP NOT NULL');
    }
}
