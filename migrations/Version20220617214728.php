<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617214728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE person');
        $this->addSql('ALTER TABLE assistant DROP fname, DROP lname, DROP num_tel, DROP email, DROP date_naissance, DROP adress');
        $this->addSql('ALTER TABLE medecin DROP fname, DROP lname, DROP num_tel, DROP email, DROP date_naissance, DROP adress');
        $this->addSql('ALTER TABLE patient DROP fname, DROP lname, DROP num_tel, DROP email, DROP date_naissance, DROP adress');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, fname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, num_tel VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_naissance DATE NOT NULL, adress VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE assistant ADD fname VARCHAR(255) NOT NULL, ADD lname VARCHAR(255) NOT NULL, ADD num_tel VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD date_naissance DATE NOT NULL, ADD adress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE medecin ADD fname VARCHAR(255) NOT NULL, ADD lname VARCHAR(255) NOT NULL, ADD num_tel VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD date_naissance DATE NOT NULL, ADD adress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE patient ADD fname VARCHAR(255) NOT NULL, ADD lname VARCHAR(255) NOT NULL, ADD num_tel VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD date_naissance DATE NOT NULL, ADD adress VARCHAR(255) NOT NULL');
    }
}
