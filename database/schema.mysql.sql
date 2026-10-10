-- Skema untuk MySQL / MariaDB (untuk SQLite tabel dibuat otomatis).
CREATE DATABASE IF NOT EXISTS crud_produk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_produk;

CREATE TABLE IF NOT EXISTS products (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sku         VARCHAR(50)    NOT NULL UNIQUE,
    name        VARCHAR(150)   NOT NULL,
    category    VARCHAR(100)   NULL,
    price       DECIMAL(15, 2) NOT NULL DEFAULT 0,
    stock       INT UNSIGNED   NOT NULL DEFAULT 0,
    description TEXT           NULL,
    created_at  DATETIME       NOT NULL,
    updated_at  DATETIME       NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
