CREATE TABLE plat (id_plat INT PRIMARY KEY, nom VARCHAR(100), description TEXT, ingredients TEXT, allergenes TEXT, id_restaurant INT REFERENCES restaurant(id_restaurant));

CREATE TABLE formule (id_formule INT PRIMARY KEY, nom VARCHAR(100), description TEXT, prix NUMBER(5,2), date_fin_validite DATE, id_restaurant INT REFERENCES restaurant(id_restaurant));

CREATE TABLE restaurant (id_restaurant INT PRIMARY KEY, nom VARCHAR(150), description TEXT, type_cuisine VARCHAR(100), id_proprio INT REFERENCES client(id_client));

CREATE TABLE client (id_client INT PRIMARY KEY, nom VARCHAR(100), prenom VARCHAR(100), email VARCHAR(255), date_inscription DATE, date_naissance DATE, id_parrain INT REFERENCES client(id_client));

CREATE TABLE avoir (id_avoir INT PRIMARY KEY, code_avoir VARCHAR(50), montant NUMBER(5,2), utilisable BOOLEAN, id_client INT REFERENCES client(id_client));

CREATE TABLE commande (id_commande INT PRIMARY KEY, date_commande DATE, mode_paiement VARCHAR(50), adresse_livraison VARCHAR(255), date_livraison DATE, montant_total NUMBER(10, 2), numero_facture INT, id_livreur INT REFERENCES liveur(id_livreur));

CREATE TABLE Livreur (id_livreur INT PRIMARY KEY, nom VARCHAR(100), prenom VARCHAR(100), Coordonnées TEXT, Région VARCHAR(100), numero_permis_conduire VARCHAR(50), date_obtention_permis DATE, date_visite_médicale DATE);

CREATE TABLE adresse (id_adresse INT PRIMARY KEY, adresse TEXT, livaison_active BOOLEAN, id_client INT REFERENCES client(id_client));

CREATE TABLE photo_plat (id_photo INT PRIMARY KEY, url_photo VARCHAR(255), description TEXT, id_plat INT REFERENCES plat(id_plat));

CREATE TABLE visite (id_visite INT PRIMARY KEY, date DATE, id_livreur INT REFERENCES livreur(id_livreur));

CREATE TABLE moderateur (id_moderateur INT PRIMARY KEY, id_user INT REFERENCES client(id_client));

CREATE TABLE banissement (id_banissement INT PRIMARY KEY, raison TEXT, date_heure TIMESTAMP, id_modérateur INT REFERENCES moderateur(id_modérateur),id_client INT REFERENCES client(id_client));

CREATE TABLE contient (id_plat INT, id_formule INT, id_plat INT REFERENCES plat(id_plat), id_formule INT REFERENCES formule(id_formule));

CREATE TABLE contient_commande (id_plat INT REFERENCES plat(id_plat), id_commande INT REFERENCES commande(id_commande), quantité INT);

CREATE TABLE passe (id_client INT REFERENCES client(id_client), id_commande INT REFERENCES commande(id_commande), id_transaction VARCHAR(50), montant NUMBER(10, 2), moyen_paiement VARCHAR(50));

CREATE TABLE transfer (id_transfert INT PRIMARY KEY, avoir_depart INT REFERENCES avoir(id_avoir), avoir_destination INT REFERENCES avoir(id_avoir));
