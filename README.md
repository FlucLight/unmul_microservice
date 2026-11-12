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

Sistem terdiri dari lima komponen utama yang saling terhubung menggunakan protokol HTTP melalui REST API Client.

```mermaid
graph TD
    User([Web Browser / User]) <--> Laravel[Laravel 11 Web Frontend / Port 8080]
    Laravel <-->|HTTP REST Client| API1[FastAPI Service 1 / Port 8000<br/>Master Tugas Dosen]
    Laravel <-->|HTTP REST Client| API2[FastAPI Service 2 / Port 8001<br/>Pengumpulan & Penilaian Tugas]
    Laravel <-->|HTTP REST Client| API3[FastAPI Service 3 / Port 8002<br/>Modul Kuliah]
    Laravel <-->|Validasi NIM, sinkronisasi, & Kelola Massal NIM (proxy server-side)| API4[FastAPI Service 4 / Port 8003<br/>Cek NIM Mahasiswa]
    Laravel <--> DBLaravel[(MySQL: unmul_microservice)]
    API1 <--> DB1[(MySQL: db_crudt)]
    API2 <--> DB2[(MySQL: db_tugas)]
    API3 <--> DB3[(MySQL: db_modul)]
    API4 <--> DB4[(MySQL: db_cek)]
```

### Komponen Utama

1. **Laravel Web Frontend (Port 8080)**

   Aplikasi web utama berbasis Laravel 11 + Jetstream (Blade) + Tailwind CSS. Bertugas menyajikan antarmuka interaktif, autentikasi pengguna, otorisasi berbasis peran (RBAC), profil pengguna, manajemen akun admin, serta memanggil REST API ke microservices backend (termasuk proxy server-side ke layanan Cek NIM).

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

5. **FastAPI Service 4 - Cek NIM (Port 8003)**

   Microservice Python (`API_cek-nim`) berbasis FastAPI dan SQLModel untuk memverifikasi dan mengelola data NIM mahasiswa (NIM + password) pada database mahasiswa. Dipakai oleh Laravel untuk validasi/sinkronisasi NIM saat pendaftaran & pengelolaan akun Mahasiswa, serta sebagai sumber data untuk halaman **Kelola Massal NIM** (proxy server-side, admin-only).

   - Database: `db_cek` (tabel `modul`)

---

## Otorisasi Berbasis Peran (RBAC)

Sistem menerapkan middleware `CheckRole` pada Laravel untuk mengatur hak akses berdasarkan peran pengguna (`role`). Terdapat tiga peran, yaitu:

- **Admin**

  Memiliki akses penuh ke seluruh fitur sistem, meliputi manajemen tugas, pengumpulan tugas, penilaian, modul kuliah, arsip tugas, profil, serta manajemen pengguna: **Manajemen Akun** (`/admin/pengguna`) dan **Kelola Massal NIM** (`/admin/pengguna/massal`).

- **Dosen**

  Dapat membuat, memperbarui, dan menghapus tugas kuliah, memberikan nilai beserta catatan penilaian, mengunggah/mengedit/menghapus modul kuliah, mengakses arsip tugas, serta mengelola profil. Dosen hanya dapat mengelola tugas dan modul yang dibuat oleh dirinya sendiri (sesuai logika aplikasi).

- **Mahasiswa**

  Dapat melihat daftar tugas dan modul, mengumpulkan tugas (tautan/file), serta mengelola profilnya sendiri.

> **Catatan penting:** Registrasi mandiri (publik) dinonaktifkan. Akun dibuat oleh Admin melalui halaman **Manajemen Akun**. Login menggunakan **Nomor Induk (NIM/NIP)** beserta kredensial yang ditetapkan. NIM pada akun Mahasiswa diverifikasi terhadap database mahasiswa melalui FastAPI Service 4 (Port 8003) saat pendaftaran/perubahan relevan — hanya NIM terdaftar yang dapat digunakan untuk akun Mahasiswa.

---

## Fitur Utama

- **UI Modern dan Responsif**

  Berbasis Tailwind CSS dengan gaya konsisten (kartu rounded, aksen oranye) dan dukungan tema **Terang / Gelap / Sistem** (tersimpan di `localStorage`, mengikuti preferensi sistem bila dipilih), adaptif untuk desktop dan mobile.

- **Autentikasi & Keamanan**

  Login via Nomor Induk (NIM/NIP) dengan Laravel Jetstream/Sanctum/Fortify, RBAC middleware (`CheckRole`), serta API key untuk komunikasi ke layanan Cek NIM (dikelola server-side pada fitur kelola massal).

- **Profil Pengguna (`/user/profile`)**

  Halaman profil bergaya 2 kolom (konsisten dengan halaman Tugas/Modul): ubah **username** (3–30 karakter, huruf kecil/angka/`_`/`.`, unik), bio (opsional, maks. 160), dan informasi profil yang diizinkan; unggah/pratinjau/hapus foto profil (jpg/png/webp, ≤2MB, disimpan di `storage/app/public/avatars`) dengan fallback inisial; pengaturan tema (Terang/Gelap/Sistem) tersinkron dengan toggle navbar. **Nama asli bersifat read-only** bagi pengguna ("Nama asli dikelola oleh admin") dan setiap input `name` ditolak/di-strip di sisi server.

- **Manajemen Akun oleh Admin (`/admin/pengguna`)**

  Admin dapat mendaftarkan, mengubah, dan menghapus akun Mahasiswa/Dosen/Admin (NIM/NIP, email, role). Dilengkapi pencarian/filter, kartu statistik, edit data, reset password, dan proteksi (tidak dapat menghapus akun sendiri). Untuk role Mahasiswa, NIM diverifikasi ke database mahasiswa (API Cek NIM, Port 8003) saat pembuatan/perubahan NIM atau pengalihan role ke Mahasiswa.

- **Kelola Massal NIM (`/admin/pengguna/massal`, Admin)**

  Pengelolaan data **NIM + password** mahasiswa secara massal, diproksikan server-side ke **API Cek NIM** (`db_cek.modul`) sehingga API key tidak terekspos ke browser. Fitur:
  - Daftar & pencarian NIM, status koneksi layanan, checkbox pemilihan.
  - Tambah satu NIM (password kosong → default `mhs123`).
  - Import massal via teks (daftar NIM dipisah baris/koma/spasi + password default).
  - Import via file **.json / .csv / .xlsx** (maks. 5MB) berformat sederhana: hanya kolom/field `nim` dan opsional `password` (password per-baris didahulukan, lalu password default form, lalu `mhs123`); NIM duplikat di file di-dedupe, NIM yang sudah terdaftar dilewati.
  - Edit/hapus satuan, serta aksi massal: ubah password terpilih dan hapus terpilih.
  - Akses khusus admin (middleware RBAC).

- **Lupa Password 2 Langkah**

  Pengguna memasukkan email dan NIM/NIP, sistem mengirim kode verifikasi 6 digit (berlaku 60 menit). Setelah terverifikasi, pengguna dapat membuat password baru. Batas maksimal 5 kali percobaan kode untuk mencegah brute-force.

- **Manajemen Tugas Kuliah**

  Tambah, edit, hapus, dan lihat tugas kuliah terintegrasi dengan FastAPI Service 1 (Port 8000). Tersedia halaman **Arsip Tugas** (`/tugas/arsip`) untuk Dosen/Admin.

- **Sistem Pengumpulan dan Penilaian**

  Mahasiswa mengumpulkan tugas, Dosen/Admin memberi nilai (0–100) beserta catatan/umpan balik, menyetujui/menolak, atau menghapus pengumpulan sesuai hak akses. Terintegrasi dengan FastAPI Service 2 (Port 8001).

- **Manajemen Modul Kuliah**

  Dosen mengunggah/mengedit/menghapus modul materi; mahasiswa dapat mengaksesnya. Terintegrasi dengan FastAPI Service 3 (Port 8002).

- **Pemeriksaan Koneksi Layanan**

  Indikator/status ketersediaan koneksi ke microservices FastAPI pada antarmuka aplikasi.

---

## Detail Endpoint Microservices

### Laravel Web Routes (Port 8080, memerlukan login)

| Method | Endpoint | Deskripsi | Akses |
| ------ | -------- | --------- | ----- |
| GET | `/` | Halaman utama (welcome) | Publik |
| GET | `/dashboard` | Redirect ke daftar tugas | Login |
| GET | `/tugas` | Halaman daftar tugas kuliah | Login |
| GET | `/tugas/arsip` | Arsip tugas kuliah | Dosen, Admin |
| GET | `/modul` | Halaman daftar modul kuliah | Login |
| POST | `/tugas` | Menambahkan tugas kuliah | Dosen, Admin |
| PUT | `/tugas/{id}` | Mengubah data tugas kuliah | Dosen, Admin |
| DELETE | `/tugas/{id}` | Menghapus tugas kuliah | Dosen, Admin |
| POST | `/kumpul-tugas` | Mengumpulkan tugas mahasiswa | Mahasiswa, Admin |
| PATCH | `/kumpul-tugas/{id}/nilai` | Memberi nilai dan catatan dosen | Dosen, Admin |
| PATCH | `/kumpul-tugas/{id}/setujui` | Menyetujui pengumpulan tugas | Dosen, Admin |
| PATCH | `/kumpul-tugas/{id}/tolak` | Menolak pengumpulan tugas | Dosen, Admin |
| DELETE | `/kumpul-tugas/{id}` | Menghapus pengumpulan tugas | Dosen, Admin |
| POST | `/modul` | Menambahkan modul kuliah | Dosen, Admin |
| PUT | `/modul/{id}` | Mengubah modul kuliah | Dosen, Admin |
| DELETE | `/modul/{id}` | Menghapus modul kuliah | Dosen, Admin |
| GET | `/admin/pengguna` | Halaman manajemen akun pengguna | Admin |
| POST | `/admin/pengguna` | Mendaftarkan akun baru | Admin |
| PUT | `/admin/pengguna/{id}` | Mengubah data akun / reset password | Admin |
| DELETE | `/admin/pengguna/{id}` | Menghapus akun (tidak dapat menghapus akun sendiri) | Admin |
| GET | `/admin/pengguna/massal` | Kelola Massal NIM (proxy ke API Cek NIM) | Admin |
| POST | `/admin/pengguna/massal` | Tambah satu NIM | Admin |
| POST | `/admin/pengguna/massal/import` | Import massal NIM dari teks | Admin |
| POST | `/admin/pengguna/massal/import-file` | Import massal NIM dari file JSON/CSV/XLSX (nim+password) | Admin |
| PUT | `/admin/pengguna/massal/{nim}` | Ubah data NIM/password | Admin |
| DELETE | `/admin/pengguna/massal/{nim}` | Hapus satu NIM | Admin |
| POST | `/admin/pengguna/massal/bulk-update` | Ubah password massal (NIM terpilih) | Admin |
| POST | `/admin/pengguna/massal/bulk-delete` | Hapus massal (NIM terpilih) | Admin |
| GET | `/user/profile` | Halaman profil pengguna | Login |
| PUT | `/user/profile` | Memperbarui profil (username/bio/dll; nama dikelola admin) | Login |
| POST | `/user/profile/avatar` | Unggah/perbarui foto profil | Login |
| DELETE | `/user/profile/avatar` | Hapus foto profil | Login |
| PUT | `/user/profile/password` | Ubah password | Login |

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
| PATCH | `/beri-nilai/{kumpul_id}` | Memberikan nilai (`nilai`: 0–100, `catatan_dosen`: opsional) |
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

### FastAPI Service 4 - Cek NIM (Port 8003)

Service ini dilindungi API key (`Authorization: Bearer <API_KEY>`) untuk endpoint data/manajemen.

| Method | Endpoint | Deskripsi |
| ------ | -------- | --------- |
| GET | `/` | Cek status server |
| GET | `/cek-nim/{nim}` | Memeriksa apakah NIM terdaftar pada database mahasiswa |
| GET | `/ambil-nim` | Mengambil daftar seluruh NIM yang terdaftar |
| POST | `/tambah-nim` | Menambahkan **satu** NIM baru (body: `{"nim": 2109106001, "password": "mhs123"}`) |
| POST | `/import-nim` | **Bulk import** banyak NIM sekaligus (body: `{"nims": [2109106001, 2109106002], "password": "mhs123"}`). NIM yang sudah ada dilewati. |
| PATCH | `/edit-nim/{nim}` | Mengubah NIM dan/atau password |
| PATCH | `/edit-nim-massal` | Ubah password/data NIM secara massal |
| DELETE | `/hapus-nim/{nim}` | Menghapus NIM dari database mahasiswa |
| POST | `/hapus-nim-massal` | Menghapus banyak NIM sekaligus |
| GET | `/kelola` | Halaman UI bawaan service untuk kelola data NIM (opsional, membutuhkan input API key di browser) |
| GET | `/docs` | Dokumentasi API (Scalar/Swagger sesuai konfigurasi service) |

> **Integrasi Laravel:** Halaman **Kelola Massal NIM** (`/admin/pengguna/massal`) di Laravel mem-proxy operasi ke endpoint di atas dari sisi server (admin-only) menggunakan `API_CEK_NIM_URL` dan `API_KEY`.

---

## Teknologi yang Digunakan

| Lapisan | Teknologi |
| ------- | --------- |
| Frontend Web | PHP 8.2+, Laravel 11, Blade Templates, Tailwind CSS, JavaScript, Vite |
| Backend Services | Python 3.10+, FastAPI, SQLModel, PyMySQL, Uvicorn |
| Database | MySQL Server (Laragon / XAMPP) |
| Autentikasi & Keamanan | Laravel Jetstream, Sanctum, Fortify, Custom RBAC Middleware (`CheckRole`) |
| Utilitas | Guzzle HTTP Client (proxy ke API), maatwebsite/excel (baca/impor file CSV/XLSX NIM) |

---

## Petunjuk Menjalankan Proyek

### 1. Persiapan Database (MySQL)

Pastikan MySQL Server sudah aktif. Buat 5 database baru di MySQL:

| Nama Database | Kepentingan |
| ------------- | ----------- |
| `unmul_microservice` | Web Application Laravel |
| `db_crudt` | FastAPI Service 1 (Master Tugas) |
| `db_tugas` | FastAPI Service 2 (Pengumpulan & Penilaian) |
| `db_modul` | FastAPI Service 3 (Modul Kuliah) |
| `db_cek` | FastAPI Service 4 (Cek NIM) |

Perintah SQL melalui MySQL CLI:

```sql
CREATE DATABASE IF NOT EXISTS unmul_microservice;
CREATE DATABASE IF NOT EXISTS db_crudt;
CREATE DATABASE IF NOT EXISTS db_tugas;
CREATE DATABASE IF NOT EXISTS db_modul;
CREATE DATABASE IF NOT EXISTS db_cek;
```

#### Data Awal (Seed) untuk `db_cek` (Service 4 - Cek NIM)

Agar fitur validasi NIM bisa diuji, isi tabel `modul` di database `db_cek` dengan beberapa NIM mahasiswa contoh. Tabel akan dibuat otomatis oleh FastAPI saat service dijalankan (lifespan `create_db`).

```sql
USE db_cek;

INSERT INTO modul (nim, password) VALUES
    (2109106001, 'mhs123'),
    (2109106002, 'mhs123'),
    (2109106003, 'mhs123');
```

> **Catatan:** Hanya NIM yang ada di tabel `modul` (`db_cek`) yang dianggap valid oleh API Cek NIM.

#### Konfigurasi API Key & URL Layanan Cek NIM

Secara default API key adalah `your-secret-api-key-change-me`. Untuk integrasi Laravel ↔ API Cek NIM, atur nilai yang **sama**:

- `.env` Laravel → `API_KEY=rahasia-anda` dan (opsional) `API_CEK_NIM_URL=http://127.0.0.1:8003`
- Environment/service Python (khususnya `API_cek-nim`) → `API_KEY=rahasia-anda` (harus sama)

Jika tidak diubah, default tetap dapat digunakan untuk pengembangan lokal.

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

3. Generate key, jalankan migrasi, dan tautan storage (untuk foto profil/avatar):

   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   ```

### 3. Instalasi Dependency Python (Microservices)

Pastikan Python 3.10+ sudah terinstal. Instal dependensi yang dibutuhkan oleh microservice (contoh umum):

```bash
pip install fastapi uvicorn sqlmodel pymysql pydantic
```

> Beberapa service (mis. `API_cek-nim`) memiliki `requirements.txt` dan/atau virtual environment (`.venv`) sendiri — gunakan dependensi sesuai folder service masing-masing bila tersedia.

### 4. Menjalankan Seluruh Service

Buka terminal terpisah dan jalankan masing-masing service:

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

**Terminal 4 - FastAPI Service 4 (Cek NIM / Port 8003):**

```bash
cd API_cek-nim
python -m uvicorn main:app --reload --port 8003
# atau (jika memakai venv service): .\.venv\Scripts\python.exe -m uvicorn main:app --host 127.0.0.1 --port 8003
```

**Terminal 5 - Laravel Web Server (Port 8080):**

```bash
php artisan serve --port 8080
```

### 5. Membuat Akun Admin Pertama

Karena registrasi publik dinonaktifkan, akun admin pertama dapat dibuat melalui Artisan Tinker:

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

Setelah login sebagai Admin, akun Mahasiswa dan Dosen dapat didaftarkan melalui **Manajemen Akun** (`/admin/pengguna`) dan data NIM dapat dikelola melalui **Kelola Massal NIM** (`/admin/pengguna/massal`).

### 6. Akses Aplikasi dan Dokumentasi API

| Akses | URL |
| ----- | --- |
| Halaman Utama (Welcome) | `http://127.0.0.1:8080/` |
| Halaman Login | `http://127.0.0.1:8080/login` |
| Halaman Tugas Kuliah | `http://127.0.0.1:8080/tugas` |
| Arsip Tugas (Dosen/Admin) | `http://127.0.0.1:8080/tugas/arsip` |
| Halaman Modul Kuliah | `http://127.0.0.1:8080/modul` |
| Profil Pengguna | `http://127.0.0.1:8080/user/profile` |
| Manajemen Akun (Admin) | `http://127.0.0.1:8080/admin/pengguna` |
| Kelola Massal NIM (Admin) | `http://127.0.0.1:8080/admin/pengguna/massal` |
| Swagger/Docs API 1 (Master Tugas) | `http://127.0.0.1:8000/docs` |
| Swagger/Docs API 2 (Pengumpulan Tugas) | `http://127.0.0.1:8001/docs` |
| Swagger/Docs API 3 (Modul Kuliah) | `http://127.0.0.1:8002/docs` |
| Swagger/Docs API 4 (Cek NIM) | `http://127.0.0.1:8003/docs` |
| UI Kelola NIM (bawaan Service 4) | `http://127.0.0.1:8003/kelola` |

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
