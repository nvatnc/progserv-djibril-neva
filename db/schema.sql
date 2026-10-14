USE my_database;

CREATE TABLE ecoles (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom_ecole VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE utilisateurs (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    prenom VARCHAR(100) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    photo_de_profil VARCHAR(255) NOT NULL,
    numero_de_telephone VARCHAR(20) NOT NULL UNIQUE,
    id_ecole INTEGER NOT NULL,
    FOREIGN KEY (id_ecole) REFERENCES ecoles(id)
);

CREATE TABLE plats (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom_du_plat VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    photo_du_plat VARCHAR(255),
    nombre_de_portion INTEGER NOT NULL,
    date_de_disponibilite DATE NOT NULL,
    id_utilisateur INTEGER NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);

CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom_de_la_categorie VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE etiquettes (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom_etiquette VARCHAR(100) NOT NULL UNIQUE,
    id_categorie INTEGER NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categories(id)
);

CREATE TABLE plats_etiquettes (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    id_plat INTEGER NOT NULL,
    id_etiquette INTEGER NOT NULL,
    FOREIGN KEY (id_plat) REFERENCES plats(id),
    FOREIGN KEY (id_etiquette) REFERENCES etiquettes(id)
);
