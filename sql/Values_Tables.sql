USE synexis_db;

-- Inserting into connected_object
INSERT INTO connected_object (id, name, type, status, location, created_at, room, last_used_at, owner_id, brand, description, unique_id, current_temp, target_temp, mode, view_angle, resolution, connectivity, battery_level, storage_capacity, ram, screen_size, os, signal) VALUES
(1, 'Caméra Entrée', 'caméra', 'actif', 'Entrée principale', '2025-03-31 04:08:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Thermostat Salle A', 'thermostat', 'actif', 'Salle A', '2025-03-31 04:08:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Détecteur Fumée', 'capteur', 'actif', 'Couloir B', '2025-03-31 04:08:48', 'd', '2025-04-15 14:45:00', NULL, 'toshiba', 'utile', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Climatiseur IT', 'climatiseur', 'inactif', 'Salle Serveur', '2025-03-31 04:08:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


-- Inserting into connected_object_history
INSERT INTO connected_object_history (id, object_id, modified_at, modified_by_id, previous_data) VALUES
(4, 65, '2025-04-14 19:20:04', 2, '{"os": "Windows 11", "ram": 8, "mode": null, "name": "Object A"}'),
(5, 66, '2025-04-14 19:20:36', 2, '{"os": "iOS", "ram": 8, "mode": null, "name": "iphone"}'),
(6, 67, '2025-04-14 22:41:52', 2, '{"os": "Windows 11", "ram": 8, "mode": null, "name": "Object B"}');


-- Inserting into contact_message
INSERT INTO contact_message (id, name, email, message, created_at, role) VALUES
(1, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'je voulais voir si ça marchais', '2025-03-31 20:00:05', NULL),
(2, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'c''est bon', '2025-04-03 21:43:38', 'ROLE_ADMIN'),
(3, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'voir si ça marche', '2025-04-04 15:33:45', 'ROLE_ADMIN'),
(4, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'vérification', '2025-04-13 09:53:54', 'ROLE_ADMIN'),
(5, 'mouhamadimame', 'tawfik.mouhamadimame@gmail.com', 'test', '2025-04-14 22:40:29', 'ROLE_ADMIN');


-- Inserting into delete_objet_request
INSERT INTO delete_objet_request (id, objet_id, user_id, created_at) VALUES
(1, 1, 3, '2025-04-14 14:05:23'),
(2, 14, 3, '2025-04-14 14:05:34');
