CREATE DATABASE takalo;

USE takalo;

CREATE TABLE user (
    idUser INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

SET FOREIGN_KEY_CHECKS = 0;
CREATE OR REPLACE TABLE item (
    idItem INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    idUser INT,
    idcategorie INT,
    FOREIGN KEY (idUser) REFERENCES user (idUser),
    FOREIGN KEY (idcategorie) REFERENCES categorie (idcategorie)
);

CREATE OR REPLACE TABLE categorie (
    idcategorie INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE demande (
    idDemande INT AUTO_INCREMENT PRIMARY KEY,
    idDemandeur INT,
    idObjetOffert INT,
    idObjetDemande INT,
    statut ENUM(
        'EN_ATTENTE',
        'ACCEPTEE',
        'REFUSEE',
        'ANNULEE'
    ),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idDemandeur) REFERENCES user (idUser),
    FOREIGN KEY (idObjetOffert) REFERENCES item (idItem),
    FOREIGN KEY (idObjetDemande) REFERENCES item (idItem)
);

CREATE TABLE historiqueEchange (
    idEchange INT AUTO_INCREMENT PRIMARY KEY,
    idDemande INT,
    dateEchange DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idDemande) REFERENCES demande (idDemande)
);