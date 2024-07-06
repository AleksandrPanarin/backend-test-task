<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703131914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE purchases_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE purchases (id INT NOT NULL, uuid VARCHAR(50) NOT NULL, product_id INT NOT NULL, product_title VARCHAR(255) NOT NULL, product_price_amount DECIMAL(10,2) NOT NULL, product_price_currency VARCHAR(50) NOT NULL, tax_number VARCHAR(255) NOT NULL, tax_percentage DECIMAL(10,2) NOT NULL, coupon_code VARCHAR(255) DEFAULT NULL, coupon_type VARCHAR(50) DEFAULT NULL, coupon_discount DECIMAL(10,2) DEFAULT NULL, total_amount_amount DECIMAL(10,2) NOT NULL, total_amount_currency VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA6431FED17F50A6 ON purchases (uuid)');
        $this->addSql('COMMENT ON COLUMN purchases.product_price_amount IS \'(DC2Type:custom_decimal)\'');
        $this->addSql('COMMENT ON COLUMN purchases.product_price_currency IS \'(DC2Type:currency_type)\'');
        $this->addSql('COMMENT ON COLUMN purchases.tax_percentage IS \'(DC2Type:custom_decimal)\'');
        $this->addSql('COMMENT ON COLUMN purchases.coupon_type IS \'(DC2Type:coupon_type)\'');
        $this->addSql('COMMENT ON COLUMN purchases.coupon_discount IS \'(DC2Type:custom_decimal)\'');
        $this->addSql('COMMENT ON COLUMN purchases.total_amount_amount IS \'(DC2Type:custom_decimal)\'');
        $this->addSql('COMMENT ON COLUMN purchases.total_amount_currency IS \'(DC2Type:currency_type)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE purchases_id_seq CASCADE');
        $this->addSql('DROP TABLE purchases');
    }
}
