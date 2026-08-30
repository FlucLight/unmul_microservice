# Learning Management System (LMS) & Microservices

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Python-FastAPI-009688?style=for-the-badge&logo=fastapi&logoColor=white" alt="FastAPI">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

---

## Daftar Isi

1. [Tentang Proyek](#tentang-proyek)
2. [Arsitektur Sistem (Microservices)](#arsitektur-sistem-microservices)
3. [Otorisasi Berbasis Peran (RBAC)](#otorisasi-berbasis-peran-rbac)
4. [Fitur Utama](#fitur-utama)
5. [Detail Endpoint Microservices](#detail-endpoint-microservices)
6. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
7. [Petunjuk Menjalankan Proyek](#petunjuk-menjalankan-proyek)
8. [Tim Praktik Kerja Lapangan](#tim-praktik-kerja-lapangan)

---

## Tentang Proyek

Proyek ini adalah **proyek pertama** hasil kolaborasi tim Praktik Kerja Lapangan (PKL) yang beranggotakan 3 siswa dari SMK Negeri 1 Tenggarong, selama periode Juli hingga Agustus 2026.

Sistem ini dirancang sebagai platform **Learning Management System (LMS)** untuk pengelolaan tugas dan modul kuliah di Fakultas Teknik Universitas Mulawarman (UNMUL). Arsitektur yang digunakan adalah **Microservices**, yang memisahkan antara antarmuka web (frontend) dan layanan backend pengolah data (API).

Tujuan utama dari pemisahan ini adalah agar setiap layanan dapat dikembangkan, dijalankan, dan diskalakan secara independen.

---

## Arsitektur Sistem (Microservices)

Sistem terdiri dari empat komponen utama yang saling terhubung menggunakan protokol HTTP melalui REST API Client.

```mermaid
graph TD
    User([Web Browser / User]) <--> Laravel[Laravel 11 Web Frontend / Port 8080]
    Laravel <-->|HTTP REST Client| API1[FastAPI Service 1 / Port 8000<br/>Master Tugas Dosen]
    Laravel <-->|HTTP REST Client| API2[FastAPI Service 2 / Port 8001<br/>Pengumpulan & Penilaian Tugas]
    Laravel <-->|HTTP REST Client| API3[FastAPI Service 3 / Port 8002<br/>Modul Kuliah]
    Laravel <--> DBLaravel[(MySQL: unmul_microservice)]
    API1 <--> DB1[(MySQL: db_crudt)]
    API2 <--> DB2[(MySQL: db_tugas)]
    API3 <--> DB3[(MySQL: db_modul)]
```

### Komponen Utama

1. **Laravel Web Frontend (Port 8080)**

   Aplikasi web utama berbasis Laravel 11 + Jetstream (Blade) + Tailwind CSS. Bertugas menyajikan antarmuka interaktif, autentikasi pengguna, otorisasi berbasis peran (RBAC), serta memanggil REST API ke seluruh microservices backend.

   - Database: `unmul_microservice`

2. **FastAPI Service 1 - Master Tugas (Port 8000)**

   Microservice Python (`API_Tugas-Mahasiswa`) berbasis FastAPI dan SQLModel untuk mengelola data master tugas kuliah (CRUD Tugas) yang dibuat oleh dosen.

   - Database: `db_crudt`

3. **FastAPI Service 2 - Pengumpulan & Penilaian (Port 8001)**

   Microservice Python (`API_Penilaian-Tugas-Mahasiswa`) berbasis FastAPI dan SQLModel untuk menangani proses pengumpulan tugas oleh mahasiswa serta pemberian nilai oleh dosen.

   - Database: `db_tugas`

4. **FastAPI Service 3 - Modul Kuliah (Port 8002)**

   Microservice Python (`API_Modul-Kuliah`) berbasis FastAPI dan SQLModel untuk mengelola modul materi perkuliahan (CRUD Modul) yang diunggah oleh dosen.

   - Database: `db_modul`

---

## Otorisasi Berbasis Peran (RBAC)

Sistem menerapkan middleware `CheckRole` pada Laravel untuk mengatur hak akses berdasarkan peran pengguna (`role`). Terdapat tiga peran, yaitu:

- **Admin**

  Memiliki akses penuh ke seluruh fitur sistem, meliputi manajemen tugas, pengumpulan tugas, penilaian, dan modul kuliah. Admin juga bertanggung jawab atas **Manajemen Akun**, yaitu mendaftarkan, mengubah, dan menghapus akun Mahasiswa, Dosen, atau Admin lain berdasarkan Nomor Induk (NIM/NIP).

- **Dosen**

  Dapat membuat, memperbarui, dan menghapus tugas kuliah. Dosen juga dapat memberikan nilai beserta catatan penilaian pada tugas mahasiswa, serta mengunggah, mengedit, dan menghapus modul kuliah. Dosen hanya dapat mengelola tugas dan modul yang dibuat oleh dirinya sendiri.

- **Mahasiswa**

  Dapat melihat daftar tugas kuliah dan modul kuliah, serta mengumpulkan tugas melalui tautan Google Drive atau file.

> **Catatan penting:** Registrasi mandiri (publik) dinonaktifkan. Akun hanya dapat dibuat oleh Admin atau Operator Fakultas melalui halaman **Manajemen Akun** (`/admin/pengguna`). Pengguna yang terdaftar sebelum fitur ini diaktifkan secara otomatis berperan sebagai Mahasiswa.

---

## Fitur Utama

- **UI Modern dan Responsif**

  Berbasis Tailwind CSS dengan dukungan mode gelap dan terang (tersimpan di `localStorage`), serta antarmuka yang adaptif untuk perangkat desktop dan mobile.

- **Manajemen Akun oleh Admin**

  Admin dapat mendaftarkan akun baru lengkap dengan Nomor Induk (NIM/NIP), email, dan role (Mahasiswa/Dosen/Admin). Dilengkapi dengan pencarian real-time, filter per role, kartu statistik pengguna, edit data, reset password, dan hapus akun.

- **Lupa Password 2 Langkah**

  Pengguna memasukkan email dan NIM/NIP, kemudian sistem mengirim **kode verifikasi 6 digit** yang berlaku selama 60 menit. Setelah kode terverifikasi, pengguna dapat membuat password baru. Terdapat batasan maksimal 5 kali percobaan kode untuk mencegah percobaan paksa (brute-force).

- **Manajemen Tugas Kuliah**

  Fitur Tambah, Edit, Hapus, dan Lihat Tugas Kuliah yang terintegrasi dengan FastAPI Service 1 (Port 8000), termasuk filter tugas berdasarkan dosen pengampu.

- **Sistem Pengumpulan dan Penilaian dengan Catatan Dosen**

  Mahasiswa dapat mengumpulkan tugas (tautan file), sedangkan Dosen dan Admin dapat memberikan nilai (0-100) beserta catatan atau umpan balik penilaian. Terintegrasi dengan FastAPI Service 2 (Port 8001).

- **Manajemen Modul Kuliah**

  Dosen dapat mengunggah modul materi kuliah, dan mahasiswa dapat mengunduh atau mengaksesnya. Terintegrasi dengan FastAPI Service 3 (Port 8002).

- **Triple API Connection Status Checker**

  Indikator status koneksi real-time untuk memeriksa ketersediaan FastAPI Service 1, Service 2, dan Service 3.

---

## Detail Endpoint Microservices

### Laravel Web Routes (Port 8080, memerlukan login)

| Method | Endpoint | Deskripsi | Akses |
| ------ | -------- | --------- | ----- |
| GET | `/` | Halaman utama (welcome) | Publik |
| GET | `/tugas` | Halaman daftar tugas kuliah | Login |
| GET | `/modul` | Halaman daftar modul kuliah | Login |
| POST | `/tugas` | Menambahkan tugas kuliah | Dosen, Admin |
| PUT | `/tugas/{id}` | Mengubah data tugas kuliah | Dosen, Admin |
| DELETE | `/tugas/{id}` | Menghapus tugas kuliah | Dosen, Admin |
| POST | `/kumpul-tugas` | Mengumpulkan tugas mahasiswa | Mahasiswa, Admin |
| PATCH | `/kumpul-tugas/{id}/nilai` | Memberi nilai dan catatan dosen | Dosen, Admin |
| GET | `/admin/pengguna` | Halaman manajemen akun pengguna | Admin |
| POST | `/admin/pengguna` | Mendaftarkan akun baru | Admin |
| PUT | `/admin/pengguna/{id}` | Mengubah data akun / reset password | Admin |
| DELETE | `/admin/pengguna/{id}` | Menghapus akun (tidak dapat menghapus akun sendiri) | Admin |

### Lupa Password (AJAX, tanpa login)

| Method | Endpoint | Deskripsi |
| ------ | -------- | --------- |
| POST | `/forgot-password/send-code` | Kirim kode verifikasi 6 digit ke email (validasi email dan NIM/NIP) |
| POST | `/forgot-password/verify-code` | Verifikasi kode (langkah kedua) |
| POST | `/forgot-password/reset-with-code` | Set password baru menggunakan kode yang terverifikasi |

### FastAPI Service 1 - Master Tugas (Port 8000)

| Method | Endpoint | Deskripsi |
| ------ | -------- | --------- |
| GET | `/` | Cek status server |
| GET | `/ambil-tugas` | Mengambil daftar seluruh tugas kuliah |
| POST | `/tambah` | Menambahkan data tugas baru (`nama_tugas`, `nama_dosen`, `deadline_tugas`) |
| PATCH | `/edit/{tugas_id}` | Mengubah data tugas berdasarkan ID |
| DELETE | `/hapus/{tugas_id}` | Menghapus data tugas berdasarkan ID |

### FastAPI Service 2 - Pengumpulan & Penilaian (Port 8001)

| Method | Endpoint | Deskripsi |
| ------ | -------- | --------- |
| GET | `/` | Cek status server |
| GET | `/ambil-kumpul` | Mengambil data seluruh pengumpulan tugas mahasiswa |
| POST | `/kumpul-tugas` | Mengumpulkan tugas baru (`id_tugas`, `nama_mahasiswa`, `file_mahasiswa`, `tanggal_kumpul`) |
| PATCH | `/edit-kumpul/{kumpul_id}` | Mengubah data pengumpulan tugas |
| PATCH | `/beri-nilai/{kumpul_id}` | Memberikan nilai (`nilai`: 0-100, `catatan_dosen`: opsional) |
| DELETE | `/hapus-kumpul/{kumpul_id}` | Menghapus data pengumpulan tugas |

### FastAPI Service 3 - Modul Kuliah (Port 8002)

| Method | Endpoint | Deskripsi |
| ------ | -------- | --------- |
| GET | `/` | Cek status server |
| GET | `/ambil-modul` | Mengambil daftar seluruh modul kuliah |
| GET | `/ambil-modul/{modul_id}` | Mengambil detail modul berdasarkan ID |
| POST | `/Tambah-modul` | Menambahkan modul baru (`nama_modul`, `nama_dosen`, `file_modul`, `tanggal_diupload`) |
| PATCH | `/edit-modul/{modul_id}` | Mengubah data modul perkuliahan |
| DELETE | `/hapus-modul/{modul_id}` | Menghapus data modul perkuliahan |

---

## Teknologi yang Digunakan

| Lapisan | Teknologi |
| ------- | --------- |
| Frontend Web | PHP 8.2+, Laravel 11, Blade Templates, Tailwind CSS, JavaScript, Vite |
| Backend Services | Python 3.10+, FastAPI, SQLModel, PyMySQL, Uvicorn |
| Database | MySQL Server (Laragon / XAMPP) |
| Autentikasi & Keamanan | Laravel Jetstream, Sanctum, Fortify, Custom RBAC Middleware (`CheckRole`) |

---

## Petunjuk Menjalankan Proyek

Bagian ini menjelaskan langkah-langkah untuk menjalankan seluruh sistem dari awal, mulai dari persiapan database hingga mengakses aplikasi.

### 1. Persiapan Database (MySQL)

Pastikan MySQL Server sudah aktif. Buat 4 database baru di MySQL:

| Nama Database | Kepentingan |
| ------------- | ----------- |
| `unmul_microservice` | Web Application Laravel |
| `db_crudt` | FastAPI Service 1 (Master Tugas) |
| `db_tugas` | FastAPI Service 2 (Pengumpulan & Penilaian) |
| `db_modul` | FastAPI Service 3 (Modul Kuliah) |

Perintah SQL melalui MySQL CLI:

```sql
CREATE DATABASE IF NOT EXISTS unmul_microservice;
CREATE DATABASE IF NOT EXISTS db_crudt;
CREATE DATABASE IF NOT EXISTS db_tugas;
CREATE DATABASE IF NOT EXISTS db_modul;
```

### 2. Instalasi Dependency dan Konfigurasi Laravel

1. Salin file environment dan sesuaikan konfigurasi database:

   ```bash
   cp .env.example .env
   ```

2. Instal dependensi PHP dan JavaScript:

   ```bash
   composer install --ignore-platform-reqs
   npm install
   npm run build
   ```

3. Generate key dan jalankan migrasi database Laravel:

   ```bash
   php artisan key:generate
   php artisan migrate
   ```

### 3. Instalasi Dependency Python (Microservices)

Pastikan Python 3.10+ sudah terinstal, kemudian jalankan perintah berikut untuk menginstal dependensi yang dibutuhkan oleh ketiga microservice:

```bash
pip install fastapi uvicorn sqlmodel pymysql pydantic
```

### 4. Menjalankan Seluruh Service

Buka 4 terminal terpisah dan jalankan masing-masing service:

**Terminal 1 - FastAPI Service 1 (Master Tugas / Port 8000):**

```bash
cd API_Tugas-Mahasiswa
python -m uvicorn main:app --reload --port 8000
```

**Terminal 2 - FastAPI Service 2 (Pengumpulan & Penilaian / Port 8001):**

```bash
cd API_Penilaian-Tugas-Mahasiswa
python -m uvicorn main:app --reload --port 8001
```

**Terminal 3 - FastAPI Service 3 (Modul Kuliah / Port 8002):**

```bash
cd API_Modul-Kuliah
python -m uvicorn main:app --reload --port 8002
```

**Terminal 4 - Laravel Web Server (Port 8080):**

```bash
php artisan serve --port 8080
```

### 5. Membuat Akun Admin Pertama

Karena registrasi publik dinonaktifkan, akun admin pertama harus dibuat secara manual melalui Artisan Tinker:

```bash
php artisan tinker
```

```php
App\Models\User::create([
    'name' => 'Operator Fakultas',
    'email' => 'operator@unmul.ac.id',
    'nomer_induk' => 'NIP-OPERATOR-001',
    'role' => 'admin',
    'password' => bcrypt('password-anda'),
]);
```

Setelah login sebagai Admin, akun Mahasiswa dan Dosen lainnya dapat didaftarkan melalui menu **Manajemen Akun** (`/admin/pengguna`).

### 6. Akses Aplikasi dan Dokumentasi API

Buka browser dan akses alamat berikut:

| Akses | URL |
| ----- | --- |
| Halaman Utama (Welcome) | `http://127.0.0.1:8080/` |
| Halaman Login | `http://127.0.0.1:8080/login` |
| Halaman Tugas Kuliah | `http://127.0.0.1:8080/tugas` |
| Halaman Modul Kuliah | `http://127.0.0.1:8080/modul` |
| Manajemen Akun (Admin) | `http://127.0.0.1:8080/admin/pengguna` |
| Swagger API 1 (Master Tugas) | `http://127.0.0.1:8000/docs` |
| Swagger API 2 (Pengumpulan Tugas) | `http://127.0.0.1:8001/docs` |
| Swagger API 3 (Modul Kuliah) | `http://127.0.0.1:8002/docs` |

---

## Tim Praktik Kerja Lapangan

| Informasi | Detail |
| --------- | ------ |
| Asal Sekolah | SMK Negeri 1 Tenggarong |
| Lokasi Magang | Fakultas Teknik Universitas Mulawarman (UNMUL) |
| Periode PKL | Juni sampai November 2026 |
| Anggota Tim | 3 Orang Siswa PKL |

---

Dikembangkan sebagai proyek magang pertama berbasis Microservices dan Web Development.
