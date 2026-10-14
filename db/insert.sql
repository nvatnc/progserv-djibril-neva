
-- ATTENTION : les utilisateurs, plats et associations
-- plats/étiquettes de ce fichier sont des DONNÉES FICTIVES
-- générées par une IA (Claude), uniquement pour tester
-- l'affichage et les filtres pendant le développement.
-- Les personnes, emails et numéros de téléphone n'existent pas.
-- Dans l'application, les vrais utilisateurs s'inscrivent
-- et publient leurs plats via les formulaires.



INSERT INTO ecoles (nom_ecole) VALUES
  ('EPFL'),
  ('UNIL'),
  ('HEIG-VD');



INSERT INTO categories (nom_de_la_categorie) VALUES
  ('Type de plat'),
  ('Ingrédients');



INSERT INTO etiquettes (nom_etiquette, id_categorie) VALUES
  ('Boeuf',      (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Poulet',     (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Poisson',    (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Porc',       (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Dinde',      (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Végétarien', (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Vegan',      (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Autres',     (SELECT id FROM categories WHERE nom_de_la_categorie = 'Type de plat')),
  ('Gluten',     (SELECT id FROM categories WHERE nom_de_la_categorie = 'Ingrédients')),
  ('Lactose',    (SELECT id FROM categories WHERE nom_de_la_categorie = 'Ingrédients')),
  ('Légumes',    (SELECT id FROM categories WHERE nom_de_la_categorie = 'Ingrédients')),
  ('Féculents',  (SELECT id FROM categories WHERE nom_de_la_categorie = 'Ingrédients'));



INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, photo_de_profil, numero_de_telephone, id_ecole) VALUES
  ('Léa',    'Martin', 'lea.martin@heig-vd.ch',    'hash_a_remplacer', 'uploads/profils/lea.jpg',    '0791112233', (SELECT id FROM ecoles WHERE nom_ecole = 'HEIG-VD')),
  ('Yanis',  'Benali', 'yanis.benali@unil.ch',     'hash_a_remplacer', 'uploads/profils/yanis.jpg',  '0782223344', (SELECT id FROM ecoles WHERE nom_ecole = 'UNIL')),
  ('Sofia',  'Rossi',  'sofia.rossi@epfl.ch',      'hash_a_remplacer', 'uploads/profils/sofia.jpg',  '0763334455', (SELECT id FROM ecoles WHERE nom_ecole = 'EPFL')),
  ('Moussa', 'Diallo', 'moussa.diallo@heig-vd.ch', 'hash_a_remplacer', 'uploads/profils/moussa.jpg', '0774445566', (SELECT id FROM ecoles WHERE nom_ecole = 'HEIG-VD'));



INSERT INTO plats (nom_du_plat, description, photo_du_plat, nombre_de_portion, date_de_disponibilite, id_utilisateur) VALUES
  ('Poulet yassa',          'Poulet mariné au citron et aux oignons, servi avec du riz blanc.', 'uploads/plats/yassa.jpg',     4, '2026-10-19', (SELECT id FROM utilisateurs WHERE email = 'moussa.diallo@heig-vd.ch')),
  ('Lasagnes maison',       'Lasagnes au bœuf et à la sauce tomate, gratinées au fromage.',     'uploads/plats/lasagnes.jpg',  6, '2026-10-20', (SELECT id FROM utilisateurs WHERE email = 'sofia.rossi@epfl.ch')),
  ('Curry de légumes',      'Curry doux aux légumes de saison et lait de coco, avec du riz.',   'uploads/plats/curry.jpg',     3, '2026-10-21', (SELECT id FROM utilisateurs WHERE email = 'lea.martin@heig-vd.ch')),
  ('Saumon au four',        'Pavé de saumon au four, pommes de terre et haricots verts.',       'uploads/plats/saumon.jpg',    2, '2026-10-22', (SELECT id FROM utilisateurs WHERE email = 'yanis.benali@unil.ch')),
  ('Émincé de porc',        'Émincé de porc à la crème et aux champignons, avec des pâtes.',    'uploads/plats/emince.jpg',    4, '2026-10-23', (SELECT id FROM utilisateurs WHERE email = 'sofia.rossi@epfl.ch')),
  ('Dinde aux légumes',     'Sauté de dinde aux poivrons et courgettes.',                        'uploads/plats/dinde.jpg',     3, '2026-10-24', (SELECT id FROM utilisateurs WHERE email = 'moussa.diallo@heig-vd.ch')),
  ('Salade quinoa vegan',   'Quinoa, avocat, pois chiches et vinaigrette au citron.',           NULL,                          3, '2026-10-25', (SELECT id FROM utilisateurs WHERE email = 'lea.martin@heig-vd.ch'));



INSERT INTO plats_etiquettes (id_plat, id_etiquette) VALUES
  -- Poulet yassa : Poulet, Légumes, Féculents (riz)
  ((SELECT id FROM plats WHERE nom_du_plat = 'Poulet yassa'),        (SELECT id FROM etiquettes WHERE nom_etiquette = 'Poulet')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Poulet yassa'),        (SELECT id FROM etiquettes WHERE nom_etiquette = 'Légumes')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Poulet yassa'),        (SELECT id FROM etiquettes WHERE nom_etiquette = 'Féculents')),
  -- Lasagnes maison : Boeuf, Gluten, Lactose, Féculents
  ((SELECT id FROM plats WHERE nom_du_plat = 'Lasagnes maison'),     (SELECT id FROM etiquettes WHERE nom_etiquette = 'Boeuf')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Lasagnes maison'),     (SELECT id FROM etiquettes WHERE nom_etiquette = 'Gluten')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Lasagnes maison'),     (SELECT id FROM etiquettes WHERE nom_etiquette = 'Lactose')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Lasagnes maison'),     (SELECT id FROM etiquettes WHERE nom_etiquette = 'Féculents')),
  -- Curry de légumes : Végétarien, Légumes, Féculents (riz)
  ((SELECT id FROM plats WHERE nom_du_plat = 'Curry de légumes'),    (SELECT id FROM etiquettes WHERE nom_etiquette = 'Végétarien')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Curry de légumes'),    (SELECT id FROM etiquettes WHERE nom_etiquette = 'Légumes')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Curry de légumes'),    (SELECT id FROM etiquettes WHERE nom_etiquette = 'Féculents')),
  -- Saumon au four : Poisson, Légumes, Féculents (pommes de terre)
  ((SELECT id FROM plats WHERE nom_du_plat = 'Saumon au four'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Poisson')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Saumon au four'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Légumes')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Saumon au four'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Féculents')),
  -- Émincé de porc : Porc, Gluten, Lactose, Légumes, Féculents
  ((SELECT id FROM plats WHERE nom_du_plat = 'Émincé de porc'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Porc')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Émincé de porc'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Gluten')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Émincé de porc'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Lactose')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Émincé de porc'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Légumes')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Émincé de porc'),      (SELECT id FROM etiquettes WHERE nom_etiquette = 'Féculents')),
  -- Dinde aux légumes : Dinde, Légumes (sans gluten, sans lactose, sans féculents)
  ((SELECT id FROM plats WHERE nom_du_plat = 'Dinde aux légumes'),   (SELECT id FROM etiquettes WHERE nom_etiquette = 'Dinde')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Dinde aux légumes'),   (SELECT id FROM etiquettes WHERE nom_etiquette = 'Légumes')),
  -- Salade quinoa vegan : Vegan, Légumes, Féculents (quinoa, pois chiches)
  ((SELECT id FROM plats WHERE nom_du_plat = 'Salade quinoa vegan'), (SELECT id FROM etiquettes WHERE nom_etiquette = 'Vegan')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Salade quinoa vegan'), (SELECT id FROM etiquettes WHERE nom_etiquette = 'Légumes')),
  ((SELECT id FROM plats WHERE nom_du_plat = 'Salade quinoa vegan'), (SELECT id FROM etiquettes WHERE nom_etiquette = 'Féculents'));
