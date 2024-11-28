-- Membuat database cafe_yahm
CREATE DATABASE IF NOT EXISTS cafe_yahm;
USE cafe_yahm;

-- Tabel untuk pengguna (users)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk menu
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(255) NOT NULL UNIQUE,
    deskripsi TEXT NOT NULL,
    harga DECIMAL(10, 2) NOT NULL CHECK (harga >= 0),
    kategori ENUM('makanan', 'minuman', 'snack') NOT NULL,
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk pesanan
CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(255) NOT NULL,
    nama_menu VARCHAR(255) NOT NULL,
    nomor_meja INT NOT NULL,
    jumlah INT NOT NULL CHECK (jumlah > 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (nama_menu) REFERENCES menu(nama_menu) ON DELETE CASCADE
);

-- Insert sample data ke tabel users
INSERT INTO users (username, email, password, role, avatar) VALUES
('admin', 'admin@cafe.com', 'password_hash_admin', 'admin', NULL),
('john_doe', 'john@example.com', 'password_hash_user', 'user', NULL);

-- Insert sample data ke tabel menu
INSERT INTO menu (nama_menu, deskripsi, harga, kategori, gambar) VALUES
('Nasi Goreng', 'Nasi goreng spesial dengan topping telur', 25000, 'makanan', 'nasi_goreng.jpg'),
('Es Teh Manis', 'Minuman es teh manis segar', 8000, 'minuman', 'es_teh_manis.jpg'),
('Kentang Goreng', 'Cemilan kentang goreng crispy', 15000, 'snack', 'kentang_goreng.jpg');

-- Insert sample data ke tabel pesanan
INSERT INTO pesanan (nama_pelanggan, nama_menu, nomor_meja, jumlah) VALUES
('Budi', 'Nasi Goreng', 1, 2),
('Siti', 'Es Teh Manis', 2, 1),
('Ahmad', 'Kentang Goreng', 3, 3);
