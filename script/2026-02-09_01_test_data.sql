-- Données de test pour la base de données takalo

USE takalo;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE imageItem;
TRUNCATE TABLE historiqueEchange;
TRUNCATE TABLE demande;
TRUNCATE TABLE demandeStatus;
TRUNCATE TABLE item;
TRUNCATE TABLE categorie;
TRUNCATE TABLE user;
SET FOREIGN_KEY_CHECKS = 1;

-- Les IDs servent de clés étrangères dans item et demande, donc on garde l'ordre 1..5
INSERT INTO user (idUser, username, email, password) VALUES
(1, 'alice', 'alice@example.com', '$2y$10$7JfAJguC/cFP7aEIs.ropu4to.mo7S23whAylHO5y/EdIXpNOWxZa'),
(2, 'bob', 'bob@example.com', '$2y$10$7JfAJguC/cFP7aEIs.ropu4to.mo7S23whAylHO5y/EdIXpNOWxZa'),
(3, 'claire', 'claire@example.com', '$2y$10$7JfAJguC/cFP7aEIs.ropu4to.mo7S23whAylHO5y/EdIXpNOWxZa'),
(4, 'david', 'david@example.com', '$2y$10$7JfAJguC/cFP7aEIs.ropu4to.mo7S23whAylHO5y/EdIXpNOWxZa'),
(5, 'emma', 'emma@example.com', '$2y$10$7JfAJguC/cFP7aEIs.ropu4to.mo7S23whAylHO5y/EdIXpNOWxZa');


-- Insertion des catégories
INSERT INTO categorie (name) VALUES
('Électronique'),
('Livres'),
('Vêtements'),
('Meubles'),
('Sports et Loisirs'),
('Jouets'),
('Jardinage'),
('Cuisine');

-- Insertion des items
INSERT INTO item (name, description, idUser, idcategorie, price) VALUES
-- Items d'Alice (idUser: 1)
('iPhone 12', 'Smartphone en bon état, 128GB, avec chargeur', 1, 1, 450.00),
('Le Petit Prince', 'Livre de Saint-Exupéry en excellent état', 1, 2, 8.50),
('Veste en cuir', 'Veste noire taille M, portée 2 fois', 1, 3, 75.00),

-- Items de Bob (idUser: 2)
('MacBook Pro 2020', 'Ordinateur portable 16 pouces, i7, 16GB RAM', 2, 1, 1200.00),
('Ensemble Harry Potter', 'Collection complète des 7 livres', 2, 2, 45.00),
('Vélo de ville', 'Vélo en aluminium, 21 vitesses, très bon état', 2, 5, 180.00),

-- Items de Claire (idUser: 3)
('Samsung Galaxy Tab', 'Tablette 10 pouces, 64GB, comme neuve', 3, 1, 280.00),
('Robe d\'été', 'Robe fleurie taille S, jamais portée', 3, 3, 35.00),
('Table basse', 'Table en bois massif, style scandinave', 3, 4, 120.00),
('Set de casseroles', 'Set de 5 casseroles inox, état neuf', 3, 8, 90.00),

-- Items de David (idUser: 4)
('PlayStation 5', 'Console de jeu avec 2 manettes', 4, 1, 500.00),
('Encyclopédie Universalis', '20 volumes, édition 2020', 4, 2, 150.00),
('Canapé 3 places', 'Canapé en tissu gris, confortable', 4, 4, 350.00),
('Raquettes de tennis', 'Paire de raquettes Wilson avec housse', 4, 5, 65.00),

-- Items d'Emma (idUser: 5)
('Appareil photo Canon', 'Reflex EOS 2000D avec objectif 18-55mm', 5, 1, 380.00),
('Manteau d\'hiver', 'Manteau long noir taille M, très chaud', 5, 3, 95.00),
('Lego Star Wars', 'Set Millennium Falcon complet dans sa boîte', 5, 6, 140.00),
('Tondeuse électrique', 'Tondeuse à gazon Bosch, 1 an d\'utilisation', 5, 7, 110.00);

-- Insertion des statuts de demande
INSERT INTO demandeStatus (idStatus, statusName) VALUES
(1, 'EN_ATTENTE'),
(2, 'ACCEPTEE'),
(3, 'REFUSEE'),
(4, 'ANNULEE');

-- Insertion des demandes d'échange
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt, statusAt) VALUES
-- Bob veut l'iPhone d'Alice, offre son MacBook
(2, 1, 4, 1, 1, '2026-02-08 10:30:00', NULL),

-- Claire veut le vélo de Bob, offre sa tablette
(3, 2, 7, 6, 2, '2026-02-07 14:20:00', '2026-02-07 15:00:00'),

-- David veut la veste d'Alice, offre ses raquettes
(4, 1, 14, 3, 3, '2026-02-06 09:15:00', '2026-02-06 09:45:00'),

-- Emma veut le set Harry Potter de Bob, offre son appareil photo
(5, 2, 15, 5, 1, '2026-02-09 08:00:00', NULL),

-- Alice veut la PS5 de David, offre son livre
(1, 4, 2, 11, 1, '2026-02-08 16:45:00', NULL),

-- Claire veut le canapé de David, offre sa table basse
(3, 4, 9, 13, 2, '2026-02-05 11:30:00', '2026-02-05 12:10:00'),

-- Bob veut le manteau d'Emma, offre l'encyclopédie
(2, 5, 12, 16, 4, '2026-02-04 13:20:00', '2026-02-04 14:00:00');

-- Insertion de l'historique des échanges (seulement pour les demandes acceptées)
INSERT INTO historiqueEchange (idDemande, idDemandeur, idOffreur, idObjetOffert, idObjetDemande, dateEchange) VALUES
(2, 3, 2, 7, 6, '2026-02-08 10:00:00'),  -- Claire (3) échange sa tablette (7) contre le vélo de Bob (6)
(6, 3, 4, 9, 13, '2026-02-06 15:30:00'); -- Claire (3) échange sa table basse (9) contre le canapé de David (13)

-- Insertion des images des items
INSERT INTO imageItem (idItem, imageURL) VALUES
(1, 'https://example.com/images/iphone12.jpg'),
(2, 'https://example.com/images/le-petit-prince.jpg'),
(3, 'https://example.com/images/veste-cuir.jpg'),
(4, 'https://example.com/images/macbook-pro-2020.jpg'),
(5, 'https://example.com/images/harry-potter-set.jpg'),
(6, 'https://example.com/images/velo-ville.jpg'),
(7, 'https://example.com/images/galaxy-tab.jpg'),
(8, 'https://example.com/images/robe-ete.jpg'),
(9, 'https://example.com/images/table-basse.jpg'),
(10, 'https://example.com/images/set-casseroles.jpg'),
(11, 'https://example.com/images/ps5.jpg'),
(12, 'https://example.com/images/encyclopedie.jpg'),
(13, 'https://example.com/images/canape.jpg'),
(14, 'https://example.com/images/raquettes-tennis.jpg'),
(15, 'https://example.com/images/appareil-photo-canon.jpg'),
(16, 'https://example.com/images/manteau-hiver.jpg'),
(17, 'https://example.com/images/lego-star-wars.jpg'),
(18, 'https://example.com/images/tondeuse-electrique.jpg');
