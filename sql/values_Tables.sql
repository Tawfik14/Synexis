USE synexis_db;


INSERT INTO user (id, email, roles, password, pseudo, lastname, firstname, points, level, gender, dob, profile_picture) VALUES
(1, 'admin@example.com', '["ROLE_ADMIN"]', 'adminpass', 'admin', 'Admin', 'System', 100, 'expert', 'homme', '1990-01-01', NULL),
(2, 'user1@example.com', '["ROLE_USER"]', 'userpass', 'us1', 'User', 'One', 50, 'intermediaire', 'femme', '1995-06-10', NULL);


INSERT INTO service (id, name, category, description, owner_id) VALUES
(1, 'Gestion Énergie', 'energie', 'Suivi de la consommation énergétique', 1),
(2, 'Caméras Sécurité', 'securite', 'Accès en temps réel aux caméras', 2);

INSERT INTO connected_object (id, name, type, status, location, created_at, room, last_used_at, owner_id, brand, description, unique_id, current_temp, target_temp, mode, view_angle, resolution, connectivity, battery_level, storage_capacity, ram, screen_size, os, signal) VALUES
(1, 'Caméra Entrée', 'caméra', 'actif', 'Entrée principale', '2025-03-31 04:08:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Thermostat Salle A', 'thermostat', 'actif', 'Salle A', '2025-03-31 04:08:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Détecteur Fumée', 'capteur', 'actif', 'Couloir B', '2025-03-31 04:08:48', 'd', '2025-04-15 14:45:00', NULL, 'toshiba', 'utile', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Climatiseur IT', 'climatiseur', 'inactif', 'Salle Serveur', '2025-03-31 04:08:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


INSERT INTO info_public (id, title, categorie, departement, description) VALUES
(1, 'Sécurité incendie', 'alerte', 'RH', 'Test du système incendie prévu demain à 10h.'),
(2, 'Météo', 'actualite', 'Com', 'Temps ensoleillé prévu toute la journée.');

INSERT INTO contact_message (id, name, email, message, created_at, role) VALUES
(1, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'je voulais voir si ça marchais', '2025-03-31 20:00:05', NULL),
(2, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'c''est bon', '2025-04-03 21:43:38', 'ROLE_ADMIN'),
(3, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'voir si ça marche', '2025-04-04 15:33:45', 'ROLE_ADMIN'),
(4, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'vérification', '2025-04-13 09:53:54', 'ROLE_ADMIN'),
(5, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'test', '2025-04-14 22:40:29', 'ROLE_ADMIN');


INSERT INTO user_log (id, user_email, action, created_at, object_name, object_type, performed_by) VALUES
(1, 'admin@example.com', 'Connexion', '2025-04-01 08:00:00', NULL, NULL, 'admin@example.com'),
(2, 'user1@example.com', 'Ajout objet', '2025-04-02 09:15:00', 'Caméra Salon', 'connected_object', 'user1@example.com');


INSERT INTO service_log (id, action, performed_by, created_at, service_name) VALUES
(1, 'Création service', 'admin@example.com', '2025-04-01 10:00:00', 'Gestion Énergie'),
(2, 'Mise à jour service', 'user1@example.com', '2025-04-02 12:30:00', 'Caméras Sécurité');


INSERT INTO object_history (id, objet_id, action, performed_by, created_at, object_name) VALUES
(1, 1, 'Ajout', 'admin@example.com', '2025-04-01 10:15:00', 'Caméra Entrée'),
(2, 2, 'Modification', 'user1@example.com', '2025-04-03 11:00:00', 'Thermostat Salle A');

INSERT INTO connected_object_history (id, object_id, modified_at, modified_by_id, previous_data) VALUES
(4, 65, '2025-04-14 19:20:04', 2, '{"os": "Windows 11", "ram": 8, "mode": null, "name": "Object A"}'),
(5, 66, '2025-04-14 19:20:36', 2, '{"os": "iOS", "ram": 8, "mode": null, "name": "iphone"}'),
(6, 67, '2025-04-14 22:41:52', 2, '{"os": "Windows 11", "ram": 8, "mode": null, "name": "Object B"}');

INSERT INTO delete_objet_request (id, objet_id, user_id, created_at) VALUES
(1, 1, 3, '2025-04-14 14:05:23'),
(2, 14, 3, '2025-04-14 14:05:34');


INSERT INTO delete_request (id, service_id, user_id, created_at) VALUES
(1, 2, 1, '2025-04-10 15:30:00'),
(2, 1, 2, '2025-04-11 09:00:00');
