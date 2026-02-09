-- Données de test pour la base de données takalo

USE takalo;

-- Insertion des utilisateurs
INSERT INTO user (username, email, password) VALUES
('alice_martin', 'alice.martin@email.com', '$2y$10$abcdefghijklmnopqrstuv'),
('bob_dupont', 'bob.dupont@email.com', '$2y$10$wxyzabcdefghijklmnopqr'),
('claire_rousseau', 'claire.rousseau@email.com', '$2y$10$stuvwxyzabcdefghijklmn'),
('david_bernard', 'david.bernard@email.com', '$2y$10$opqrstuvwxyzabcdefghij'),
('emma_petit', 'emma.petit@email.com', '$2y$10$klmnopqrstuvwxyzabcdef');

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
INSERT INTO item (name, description, idUser, idcategorie) VALUES
-- Items d'Alice (idUser: 1)
('iPhone 12', 'Smartphone en bon état, 128GB, avec chargeur', 1, 1),
('Le Petit Prince', 'Livre de Saint-Exupéry en excellent état', 1, 2),
('Veste en cuir', 'Veste noire taille M, portée 2 fois', 1, 3),

-- Items de Bob (idUser: 2)
('MacBook Pro 2020', 'Ordinateur portable 16 pouces, i7, 16GB RAM', 2, 1),
('Ensemble Harry Potter', 'Collection complète des 7 livres', 2, 2),
('Vélo de ville', 'Vélo en aluminium, 21 vitesses, très bon état', 2, 5),

-- Items de Claire (idUser: 3)
('Samsung Galaxy Tab', 'Tablette 10 pouces, 64GB, comme neuve', 3, 1),
('Robe d\'été', 'Robe fleurie taille S, jamais portée', 3, 3),
('Table basse', 'Table en bois massif, style scandinave', 3, 4),
('Set de casseroles', 'Set de 5 casseroles inox, état neuf', 3, 8),

-- Items de David (idUser: 4)
('PlayStation 5', 'Console de jeu avec 2 manettes', 4, 1),
('Encyclopédie Universalis', '20 volumes, édition 2020', 4, 2),
('Canapé 3 places', 'Canapé en tissu gris, confortable', 4, 4),
('Raquettes de tennis', 'Paire de raquettes Wilson avec housse', 4, 5),

-- Items d'Emma (idUser: 5)
('Appareil photo Canon', 'Reflex EOS 2000D avec objectif 18-55mm', 5, 1),
('Manteau d\'hiver', 'Manteau long noir taille M, très chaud', 5, 3),
('Lego Star Wars', 'Set Millennium Falcon complet dans sa boîte', 5, 6),
('Tondeuse électrique', 'Tondeuse à gazon Bosch, 1 an d\'utilisation', 5, 7);

-- Insertion des demandes d'échange
INSERT INTO demande (idDemandeur, idObjetOffert, idObjetDemande, statut, createdAt) VALUES
-- Bob veut l'iPhone d'Alice, offre son MacBook
(2, 4, 1, 'EN_ATTENTE', '2026-02-08 10:30:00'),

-- Claire veut le vélo de Bob, offre sa tablette
(3, 7, 6, 'ACCEPTEE', '2026-02-07 14:20:00'),

-- David veut la veste d'Alice, offre ses raquettes
(4, 14, 3, 'REFUSEE', '2026-02-06 09:15:00'),

-- Emma veut le set Harry Potter de Bob, offre son appareil photo
(5, 15, 5, 'EN_ATTENTE', '2026-02-09 08:00:00'),

-- Alice veut la PS5 de David, offre son livre
(1, 2, 11, 'EN_ATTENTE', '2026-02-08 16:45:00'),

-- Claire veut le canapé de David, offre sa table basse
(3, 9, 13, 'ACCEPTEE', '2026-02-05 11:30:00'),

-- Bob veut le manteau d'Emma, offre l'encyclopédie
(2, 12, 16, 'ANNULEE', '2026-02-04 13:20:00');

-- Insertion de l'historique des échanges (seulement pour les demandes acceptées)
INSERT INTO historiqueEchange (idDemande, dateEchange) VALUES
(2, '2026-02-08 10:00:00'),  -- Échange tablette contre vélo
(6, '2026-02-06 15:30:00');  -- Échange table basse contre canapé
