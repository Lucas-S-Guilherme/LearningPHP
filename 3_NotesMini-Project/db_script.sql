CREATE DATABASE myApp CHARACTER SET = utf8mb4 COLLATE	utf8mb4_unicode_ci;
-- DROP DATABASE myApp;

USE myApp;

CREATE TABLE users (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_name VARCHAR(255) NOT NULL,
user_email VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO users (user_name, user_email) 
VALUES 
('Lucas Guilherme', 'lucassguilherme159@gmail.com'),
('Usuario padrão', 'email_teste@mail.com');

CREATE TABLE notes (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
body TEXT,
fk_user_id INT NOT NULL,
FOREIGN KEY (fk_user_id) REFERENCES users(id)
);

INSERT INTO notes (body, fk_user_id)
VALUES ('PHP for Bennigers is the Best', 1), ('Javascript is a GODNESS holy gracefull', 2);