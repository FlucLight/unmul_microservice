-- Seed data untuk database db_cek (Service 4 - Cek NIM)
-- Jalankan di MySQL: mysql -u root db_cek < seed_nim.sql
-- Atau copy-paste ke phpMyAdmin / HeidiSQL / DBeaver.

USE db_cek;

-- Pastikan tabel sudah ada (dibuat otomatis oleh FastAPI, tapi aman jika dibuat manual)
CREATE TABLE IF NOT EXISTS modul (
    id_mahasiswa INT AUTO_INCREMENT PRIMARY KEY,
    nim INT NOT NULL,
    password VARCHAR(255) NOT NULL,
    INDEX ix_modul_nim (nim),
    INDEX ix_modul_password (password)
);

-- Hapus data lama (opsional, hapus baris ini jika ingin menambah tanpa menghapus)
-- TRUNCATE TABLE modul;

-- Bulk insert NIM mahasiswa contoh (30 data)
INSERT INTO modul (nim, password) VALUES
    (2109106001, 'mhs123'),
    (2109106002, 'mhs123'),
    (2109106003, 'mhs123'),
    (2109106004, 'mhs123'),
    (2109106005, 'mhs123'),
    (2109106006, 'mhs123'),
    (2109106007, 'mhs123'),
    (2109106008, 'mhs123'),
    (2109106009, 'mhs123'),
    (2109106010, 'mhs123'),
    (2109106011, 'mhs123'),
    (2109106012, 'mhs123'),
    (2109106013, 'mhs123'),
    (2109106014, 'mhs123'),
    (2109106015, 'mhs123'),
    (2109106016, 'mhs123'),
    (2109106017, 'mhs123'),
    (2109106018, 'mhs123'),
    (2109106019, 'mhs123'),
    (2109106020, 'mhs123'),
    (2109106021, 'mhs123'),
    (2109106022, 'mhs123'),
    (2109106023, 'mhs123'),
    (2109106024, 'mhs123'),
    (2109106025, 'mhs123'),
    (2109106026, 'mhs123'),
    (2109106027, 'mhs123'),
    (2109106028, 'mhs123'),
    (2109106029, 'mhs123'),
    (2109106030, 'mhs123');

-- Cek hasil
SELECT COUNT(*) AS total_nim FROM modul;
SELECT * FROM modul LIMIT 5;
