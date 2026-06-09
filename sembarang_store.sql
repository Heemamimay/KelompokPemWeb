-- =============================================
-- SEMBARANG STORE - Database SQL
-- Import via phpMyAdmin Laragon
-- =============================================

CREATE DATABASE IF NOT EXISTS sembarang_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sembarang_store;

-- =============================================
-- TABEL ADMIN
-- =============================================
CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- TABEL PELANGGAN
-- =============================================
CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    alamat TEXT,
    no_hp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- TABEL BARANG
-- =============================================
CREATE TABLE barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(150) NOT NULL,
    merk VARCHAR(100) NOT NULL,
    harga DECIMAL(12,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    gambar VARCHAR(255) DEFAULT 'default.jpg',
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================
-- TABEL TRANSAKSI
-- =============================================
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT NOT NULL,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_harga DECIMAL(12,2) NOT NULL,
    status ENUM('pending','diproses','dikirim','selesai','dibatalkan') DEFAULT 'pending',
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================
-- TABEL DETAIL TRANSAKSI
-- =============================================
CREATE TABLE detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi) ON DELETE CASCADE,
    FOREIGN KEY (id_barang) REFERENCES barang(id_barang) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================
-- TABEL KERANJANG
-- =============================================
CREATE TABLE keranjang (
    id_keranjang INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT NOT NULL,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan) ON DELETE CASCADE,
    FOREIGN KEY (id_barang) REFERENCES barang(id_barang) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================================
-- DATA DUMMY: ADMIN
-- Password: admin123 (bcrypt)
-- =============================================
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- =============================================
-- DATA DUMMY: PELANGGAN
-- Password semua: user123 (bcrypt)
-- =============================================
INSERT INTO pelanggan (nama, email, username, password, alamat, no_hp) VALUES
('Budi Santoso', 'budi@email.com', 'budi_santoso', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jl. Merdeka No. 12, Surakarta', '081234567890'),
('Siti Rahayu', 'siti@email.com', 'siti_rahayu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jl. Sudirman No. 45, Yogyakarta', '082345678901'),
('Rizky Pratama', 'rizky@email.com', 'rizky_pratama', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jl. Gatot Subroto No. 7, Semarang', '083456789012');

-- =============================================
-- DATA DUMMY: BARANG (10 Sepatu Lokal)
-- =============================================
INSERT INTO barang (nama_barang, merk, harga, stok, gambar, deskripsi) VALUES
('Compass Gazelle Low Black', 'Compass', 389000, 25, 'default.jpg', 'Sneaker low-cut klasik dari Compass dengan upper canvas premium dan sol karet vulkanisasi. Cocok untuk gaya kasual sehari-hari. Tersedia dalam berbagai ukuran.'),
('Ventela Classic White', 'Ventela', 359000, 30, 'default.jpg', 'Sepatu sneaker putih bersih dari Ventela dengan desain minimalis yang elegan. Upper berbahan kulit sintetis berkualitas tinggi dengan sol tebal yang nyaman.'),
('Aerostreet Rhino Series Grey', 'Aerostreet', 295000, 40, 'default.jpg', 'Sneaker sporty dari Aerostreet dengan teknologi sol Rhino yang tahan lama. Desain modern dengan kombinasi warna abu-abu dan aksen hitam. Ringan dan fleksibel.'),
('Piero Jogger Navy', 'Piero', 279000, 35, 'default.jpg', 'Sepatu running casual dari Piero dengan desain jogger yang stylish. Bahan mesh breathable untuk kenyamanan maksimal. Tersedia dalam warna navy yang elegan.'),
('NAH Project Corduroy Olive', 'NAH Project', 499000, 15, 'default.jpg', 'Sneaker premium dari NAH Project dengan material corduroy pilihan. Desain unik dan eksklusif dengan warna olive yang timeless. Limited stock!'),
('Compass Widuri Canvas Cream', 'Compass', 329000, 20, 'default.jpg', 'Sepatu canvas klasik dari Compass dengan warna cream natural yang versatile. Sol putih bersih dengan konstruksi vulkanized yang kuat. Perfect untuk daily wear.'),
('Ventela Eclipse Navy Gold', 'Ventela', 419000, 18, 'default.jpg', 'Edisi spesial Ventela Eclipse dengan kombinasi warna navy dan gold yang mewah. Upper leather synthetic premium dengan detail jahitan kontras. Statement shoe terbaik.'),
('Aerostreet Street Legend Black Red', 'Aerostreet', 315000, 45, 'default.jpg', 'Sneaker streetwear dari Aerostreet seri Street Legend. Kombinasi warna hitam dan merah yang bold dan berani. Sol chunky yang stylish dan nyaman dipakai seharian.'),
('Piero Ultra Boost White', 'Piero', 345000, 28, 'default.jpg', 'Sepatu lifestyle dari Piero dengan teknologi Ultra Boost pada sol. Memberikan pantulan energi optimal untuk kenyamanan. Upper knit stretch yang mengikuti bentuk kaki.'),
('NAH Project Linen Beige', 'NAH Project', 465000, 12, 'default.jpg', 'Sneaker eksklusif NAH Project berbahan linen premium berwarna beige. Handcrafted dengan detail jahitan yang rapi. Cocok untuk tampilan smart casual.');

-- =============================================
-- DATA DUMMY: TRANSAKSI
-- =============================================
INSERT INTO transaksi (id_pelanggan, tanggal, total_harga, status) VALUES
(1, '2025-05-10 10:30:00', 748000, 'selesai'),
(2, '2025-05-15 14:20:00', 778000, 'dikirim'),
(3, '2025-05-20 09:15:00', 499000, 'diproses'),
(1, '2025-05-25 16:45:00', 315000, 'pending');

-- =============================================
-- DATA DUMMY: DETAIL TRANSAKSI
-- =============================================
INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, subtotal) VALUES
(1, 1, 1, 389000),
(1, 3, 1, 295000),
(2, 2, 1, 359000),
(2, 4, 1, 279000),
(2, 6, 1, 329000),
(3, 5, 1, 499000),
(4, 8, 1, 315000);
