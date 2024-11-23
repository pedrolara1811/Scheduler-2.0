
CREATE DATABASE IF NOT EXISTS scheduler;

USE scheduler;

CREATE TABLE IF NOT EXISTS contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    lada INT NOT NULL,
    phone INT NOT NULL
);


CREATE TABLE IF NOT EXISTS address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    street VARCHAR(255) NOT NULL,
    house_number INT NOT NULL,
    suburb VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    postal_code VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT,
    address_id INT,
    schedule_date DATETIME,
    FOREIGN KEY (contact_id) REFERENCES contact(id),
    FOREIGN KEY (address_id) REFERENCES address(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'standard') NOT NULL
);

INSERT INTO users (username, password, role) 
VALUES
('admin', SHA2('admin_password', 256), 'admin'),
('viewer', SHA2('viewer_password', 256), 'standard');

