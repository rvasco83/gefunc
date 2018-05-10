<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180509194308 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE funcionario (id INT AUTO_INCREMENT NOT NULL, secretaria_id INT NOT NULL, nome VARCHAR(255) NOT NULL, logadouro VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, bairro VARCHAR(255) NOT NULL, cidade VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, identidade VARCHAR(10) NOT NULL, imagem_documento VARCHAR(255) NOT NULL, cargo VARCHAR(1) NOT NULL, status VARCHAR(1) NOT NULL, data_admissao DATE NOT NULL, data_exoneracao DATE DEFAULT NULL, salario_base NUMERIC(10, 2) NOT NULL, gratificacao NUMERIC(10, 2) DEFAULT NULL, desconto NUMERIC(10, 2) NOT NULL, salario_liquido NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_7510A3CF49FCAEDF (identidade), INDEX IDX_7510A3CF584CC12E (secretaria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secretaria (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, matricula INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE funcionario ADD CONSTRAINT FK_7510A3CF584CC12E FOREIGN KEY (secretaria_id) REFERENCES secretaria (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE funcionario DROP FOREIGN KEY FK_7510A3CF584CC12E');
        $this->addSql('DROP TABLE funcionario');
        $this->addSql('DROP TABLE secretaria');
        $this->addSql('DROP TABLE usuario');
    }
}
