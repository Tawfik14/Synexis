CREATE DATABASE IF NOT EXISTS synexis_db;
USE synexis_db;

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255),
    roles TEXT,
    password VARCHAR(255),
    pseudo VARCHAR(255),
    lastname VARCHAR(255),
    firstname VARCHAR(255),
    points FLOAT,
    level VARCHAR(255),
    gender VARCHAR(255),
    dob DATE,
    profile_picture VARCHAR(255)
);


CREATE TABLE IF NOT EXISTS user_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255),
    action VARCHAR(255),
    created_at DATETIME,
    object_name VARCHAR(255),
    object_type VARCHAR(255),
    performed_by VARCHAR(255)
);


CREATE TABLE IF NOT EXISTS service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    category VARCHAR(255),
    description TEXT,
    owner_id INT
);


CREATE TABLE IF NOT EXISTS service_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    action VARCHAR(255),
    performed_by VARCHAR(255),
    created_at DATETIME,
    service_name VARCHAR(255)
);


CREATE TABLE IF NOT EXISTS object_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objet_id INT,
    action VARCHAR(255),
    performed_by VARCHAR(255),
    created_at DATETIME,
    object_name VARCHAR(255)
);


CREATE TABLE IF NOT EXISTS info_public (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    categorie VARCHAR(255),
    departement VARCHAR(255),
    description TEXT
);


CREATE TABLE IF NOT EXISTS delete_request (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT,
    user_id INT,
    created_at DATETIME
);



CREATE TABLE IF NOT EXISTS delete_objet_request (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objet_id INT,
    user_id INT,
    created_at DATETIME
);


CREATE TABLE IF NOT EXISTS contact_message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    message TEXT,
    created_at DATETIME,
    role VARCHAR(255)
);


CREATE TABLE IF NOT EXISTS connected_object_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    object_id INT,
    modified_at DATETIME,
    modified_by_id INT,
    previous_data TEXT
);


CREATE TABLE IF NOT EXISTS connected_object (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    type VARCHAR(255),
    status VARCHAR(255),
    location VARCHAR(255),
    created_at DATETIME,
    room VARCHAR(255),
    last_used_at DATETIME,
    owner_id INT,
    brand VARCHAR(255),
    description TEXT,
    unique_id VARCHAR(255),
    current_temp FLOAT,
    target_temp FLOAT,
    mode VARCHAR(255),
    view_angle INT,
    resolution VARCHAR(255),
    connectivity VARCHAR(255),
    battery_level INT,
    storage_capacity INT,
    ram INT,
    screen_size FLOAT,
    os VARCHAR(255),
    signal VARCHAR(255)
);
