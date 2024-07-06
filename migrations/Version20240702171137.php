<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702171137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE coupons_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coupons (id INT NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, discount DECIMAL(10,2) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE products (id INT NOT NULL, title VARCHAR(255) NOT NULL, in_stock INT NOT NULL, price_amount DECIMAL(10,2) NOT NULL, price_currency VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN coupons.type IS \'(DC2Type:coupon_type)\'');
        $this->addSql('COMMENT ON COLUMN coupons.discount IS \'(DC2Type:custom_decimal)\'');
        $this->addSql('COMMENT ON COLUMN products.price_amount IS \'(DC2Type:custom_decimal)\'');
        $this->addSql('COMMENT ON COLUMN products.price_currency IS \'(DC2Type:currency_type)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE coupons_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE products_id_seq CASCADE');
        $this->addSql('DROP TABLE coupons');
        $this->addSql('DROP TABLE products');
    }
}
