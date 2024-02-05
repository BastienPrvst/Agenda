<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129145219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A02990C86F3B2F');
        $this->addSql('ALTER TABLE hour DROP FOREIGN KEY FK_701E114E9C24126');
        $this->addSql('ALTER TABLE month DROP FOREIGN KEY FK_8EB6100640C1FEA7');
        $this->addSql('ALTER TABLE week DROP FOREIGN KEY FK_5B5A69C0A0CBDE4');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE hour');
        $this->addSql('DROP TABLE month');
        $this->addSql('DROP TABLE week');
        $this->addSql('DROP TABLE year');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, week_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_E5A02990C86F3B2F (week_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE hour (id INT AUTO_INCREMENT NOT NULL, day_id INT NOT NULL, occupied TINYINT(1) NOT NULL, occupation VARCHAR(300) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_701E114E9C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE month (id INT AUTO_INCREMENT NOT NULL, year_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_8EB6100640C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE week (id INT AUTO_INCREMENT NOT NULL, month_id INT NOT NULL, number SMALLINT NOT NULL, INDEX IDX_5B5A69C0A0CBDE4 (month_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE year (id INT AUTO_INCREMENT NOT NULL, year SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A02990C86F3B2F FOREIGN KEY (week_id) REFERENCES week (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE hour ADD CONSTRAINT FK_701E114E9C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE month ADD CONSTRAINT FK_8EB6100640C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE week ADD CONSTRAINT FK_5B5A69C0A0CBDE4 FOREIGN KEY (month_id) REFERENCES month (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
