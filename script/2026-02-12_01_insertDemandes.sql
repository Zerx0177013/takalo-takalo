-- Insert test data for demande table
-- Testing the getAllDemandeFromMyself function

-- Rohan (id=2) requests to Alice (id=1)
-- Status 1 = Pending, 2 = Accepted, 3 = Refused


USE takalo;
-- 1. Rohan offers his book (11) for Alice's iPhone (1) - PENDING
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt) 
VALUES (2, 1, 11, 1, 1, '2026-02-10 14:30:00');

-- 2. Rohan offers his book (11) for Alice's Petit Prince book (2) - ACCEPTED
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt, statusAt) 
VALUES (2, 1, 11, 2, 2, '2026-02-09 10:15:00', '2026-02-09 16:45:00');

-- 3. Rohan offers his book (11) for Alice's leather jacket (3) - REFUSED
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt, statusAt) 
VALUES (2, 1, 11, 3, 3, '2026-02-08 09:20:00', '2026-02-08 11:30:00');

-- 4. Rohan offers his book (11) for Alice's toy (4) - PENDING
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt) 
VALUES (2, 1, 11, 4, 1, '2026-02-11 18:00:00');

-- 5. Rohan offers his book (11) for Alice's sports item (6) - PENDING
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt) 
VALUES (2, 1, 11, 6, 1, '2026-02-12 08:30:00');


-- Alice (id=1) requests to Rohan (id=2)
-- These won't show up in Rohan's "mes demandes" but will be visible in "demandes received"

-- 6. Alice offers her iPhone (1) for Rohan's book (11) - PENDING
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt) 
VALUES (1, 2, 1, 11, 1, '2026-02-07 12:00:00');

-- 7. Alice offers her Petit Prince (2) for Rohan's book (11) - ACCEPTED
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt, statusAt) 
VALUES (1, 2, 2, 11, 2, '2026-02-06 15:20:00', '2026-02-06 20:10:00');

-- 8. Alice offers her jacket (3) for Rohan's book (11) - REFUSED  
INSERT INTO demande (idDemandeur, idReceveur, idObjetOffert, idObjetDemande, idDemandeStatus, createdAt, statusAt) 
VALUES (1, 2, 3, 11, 3, '2026-02-05 11:45:00', '2026-02-05 14:20:00');

-- Display results
SELECT 'Demandes created successfully!' AS Result;
SELECT * FROM demande ORDER BY createdAt DESC;
