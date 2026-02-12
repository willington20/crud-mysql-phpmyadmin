CREATE DATABASE IF NOT EXISTS app_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE app_db;

CREATE TABLE IF NOT EXISTS authors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author_id INT,
  published_year INT,
  FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE SET NULL
);

INSERT INTO authors (name) VALUES ('Gabriel García Márquez'), ('Isabel Allende');
INSERT INTO books (title, author_id, published_year) VALUES ('Cien años de soledad', 1, 1967), ('La casa de los espíritus', 2, 1982);
