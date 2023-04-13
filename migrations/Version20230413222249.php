<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413222249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrator (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, original_name VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, gender VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_logged_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6493DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrator ADD CONSTRAINT FK_58DF0651BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE lafleur_adresses DROP FOREIGN KEY FK_83A3E8BBB2B59251');
        $this->addSql('ALTER TABLE lafleur_adresses DROP FOREIGN KEY FK_83A3E8BBA73F0036');
        $this->addSql('ALTER TABLE lafleur_clients DROP FOREIGN KEY FK_BC902A2076325FF4');
        $this->addSql('ALTER TABLE lafleur_commandes DROP FOREIGN KEY fk_lafleur_commandes_lafleur_lots1');
        $this->addSql('ALTER TABLE lafleur_commandes DROP FOREIGN KEY fk_commande_client1');
        $this->addSql('ALTER TABLE lafleur_commande_produits DROP FOREIGN KEY fk_commande_has_produit_commande1');
        $this->addSql('ALTER TABLE lafleur_commande_produits DROP FOREIGN KEY fk_commande_has_produit_produit1');
        $this->addSql('ALTER TABLE lafleur_produits DROP FOREIGN KEY fk_lafleur_produits_type_plante1');
        $this->addSql('ALTER TABLE lafleur_produits DROP FOREIGN KEY fk_lafleur_produits_unite1');
        $this->addSql('ALTER TABLE lafleur_produits DROP FOREIGN KEY fk_produit_couleur');
        $this->addSql('ALTER TABLE lafleur_produits_categories DROP FOREIGN KEY fk_produit_has_categories_categories1');
        $this->addSql('ALTER TABLE lafleur_produits_categories DROP FOREIGN KEY fk_produit_has_categories_produit1');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE lafleur_adresses');
        $this->addSql('DROP TABLE lafleur_categories');
        $this->addSql('DROP TABLE lafleur_clients');
        $this->addSql('DROP TABLE lafleur_code_postal');
        $this->addSql('DROP TABLE lafleur_commandes');
        $this->addSql('DROP TABLE lafleur_commande_produits');
        $this->addSql('DROP TABLE lafleur_couleurs');
        $this->addSql('DROP TABLE lafleur_lots');
        $this->addSql('DROP TABLE lafleur_produits');
        $this->addSql('DROP TABLE lafleur_produits_categories');
        $this->addSql('DROP TABLE lafleur_type_plante');
        $this->addSql('DROP TABLE lafleur_unite');
        $this->addSql('DROP TABLE lafleur_villes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (idadmin INT AUTO_INCREMENT NOT NULL, login VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, pwd VARCHAR(64) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, emailAdmin VARCHAR(64) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(idadmin)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_adresses (id_adresse INT AUTO_INCREMENT NOT NULL, code_postal_id INT DEFAULT NULL, ville_id INT DEFAULT NULL, adresse VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, complement_adresse VARCHAR(255) CHARACTER SET utf8 DEFAULT \'NULL\' COLLATE `utf8_general_ci`, INDEX fk_adresse_ville1_idx (ville_id), INDEX fk_adresse_code_postal1_idx (code_postal_id), PRIMARY KEY(id_adresse)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_categories (idcategories INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(idcategories)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_clients (id_client INT AUTO_INCREMENT NOT NULL, lafleur_adresses_id INT DEFAULT NULL, nom_client VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, prenom_client VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, email_client VARCHAR(64) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, mot_de_passe VARCHAR(70) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, telephone VARCHAR(15) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, UNIQUE INDEX emailClient_UNIQUE (email_client), INDEX fk_lafleur_clients_lafleur_adresses1_id (lafleur_adresses_id), PRIMARY KEY(id_client)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_code_postal (id_code_postal INT AUTO_INCREMENT NOT NULL, code_postal CHAR(5) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id_code_postal)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_commandes (id_commande INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, lot_id INT DEFAULT NULL, date_commande DATETIME NOT NULL, livraison_souhaitee DATETIME NOT NULL, date_livraison DATETIME DEFAULT NULL, etat_commande VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, INDEX fk_lafleur_commandes_lafleur_lots1_idx (lot_id), INDEX fk_commande_client1_idx (client_id), PRIMARY KEY(id_commande)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_commande_produits (commande_id INT NOT NULL, produit_id INT NOT NULL, quantite INT NOT NULL, INDEX fk_commande_has_produit_produit1_id (produit_id), INDEX fk_commande_has_produit_commande1_id (commande_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_couleurs (idcouleur INT AUTO_INCREMENT NOT NULL, nom_couleur VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(idcouleur)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_lots (id_lot INT NOT NULL, nom_lot VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, quantite INT NOT NULL, m_a_j DATETIME DEFAULT NULL, PRIMARY KEY(id_lot)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_produits (id_produit INT AUTO_INCREMENT NOT NULL, plante_id INT NOT NULL, couleur_id INT NOT NULL, unite_id INT NOT NULL, prix NUMERIC(5, 2) NOT NULL, description VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, image1 VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, image2 VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, lien_blog VARCHAR(64) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, stock INT NOT NULL, date_m_a_j DATETIME NOT NULL, INDEX fk_lafleur_produits_type_plante1_id (plante_id), INDEX fk_lafleur_produits_unite1_id (unite_id), INDEX fk_produit_couleur_id (couleur_id), PRIMARY KEY(id_produit)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_produits_categories (categories_idcategories INT NOT NULL, produit_idProduit INT NOT NULL, INDEX IDX_B1AC8329495F3144 (categories_idcategories), INDEX IDX_B1AC8329BD8BD939 (produit_idProduit), PRIMARY KEY(categories_idcategories, produit_idProduit)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_type_plante (id_type_plante INT AUTO_INCREMENT NOT NULL, nom_plante VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, description VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id_type_plante)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_unite (id_unite INT AUTO_INCREMENT NOT NULL, type_unite VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id_unite)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lafleur_villes (id_ville INT AUTO_INCREMENT NOT NULL, ville VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(id_ville)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lafleur_adresses ADD CONSTRAINT FK_83A3E8BBB2B59251 FOREIGN KEY (code_postal_id) REFERENCES lafleur_code_postal (id_code_postal)');
        $this->addSql('ALTER TABLE lafleur_adresses ADD CONSTRAINT FK_83A3E8BBA73F0036 FOREIGN KEY (ville_id) REFERENCES lafleur_villes (id_ville)');
        $this->addSql('ALTER TABLE lafleur_clients ADD CONSTRAINT FK_BC902A2076325FF4 FOREIGN KEY (lafleur_adresses_id) REFERENCES lafleur_adresses (id_adresse)');
        $this->addSql('ALTER TABLE lafleur_commandes ADD CONSTRAINT fk_lafleur_commandes_lafleur_lots1 FOREIGN KEY (lot_id) REFERENCES lafleur_lots (id_lot) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_commandes ADD CONSTRAINT fk_commande_client1 FOREIGN KEY (client_id) REFERENCES lafleur_clients (id_client) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_commande_produits ADD CONSTRAINT fk_commande_has_produit_commande1 FOREIGN KEY (commande_id) REFERENCES lafleur_commandes (id_commande) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_commande_produits ADD CONSTRAINT fk_commande_has_produit_produit1 FOREIGN KEY (produit_id) REFERENCES lafleur_produits (id_produit) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_produits ADD CONSTRAINT fk_lafleur_produits_type_plante1 FOREIGN KEY (plante_id) REFERENCES lafleur_type_plante (id_type_plante) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_produits ADD CONSTRAINT fk_lafleur_produits_unite1 FOREIGN KEY (unite_id) REFERENCES lafleur_unite (id_unite) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_produits ADD CONSTRAINT fk_produit_couleur FOREIGN KEY (couleur_id) REFERENCES lafleur_couleurs (idcouleur) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_produits_categories ADD CONSTRAINT fk_produit_has_categories_categories1 FOREIGN KEY (categories_idcategories) REFERENCES lafleur_categories (idcategories) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE lafleur_produits_categories ADD CONSTRAINT fk_produit_has_categories_produit1 FOREIGN KEY (produit_idProduit) REFERENCES lafleur_produits (id_produit) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE administrator DROP FOREIGN KEY FK_58DF0651BF396750');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78BF396750');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493DA5256D');
        $this->addSql('DROP TABLE administrator');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
    }
}
