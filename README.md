<div align="center">

**Rancang Bangun REST API Sistem Informasi Pendaftaran Online PAUD TK Aqila Menggunakan GoFiber Framework dengan Metode Agile**

[![Go](https://img.shields.io/badge/Go-1.20+-00ADD8?style=for-the-badge&logo=go&logoColor=white)](https://go.dev)
[![GoFiber](https://img.shields.io/badge/GoFiber-v2-00ADD8?style=for-the-badge&logo=go&logoColor=white)](https://gofiber.io)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![GORM](https://img.shields.io/badge/GORM-v1.25-29BEB0?style=for-the-badge&logo=gorm&logoColor=white)](https://gorm.io)

> Sistem pendaftaran online terpadu untuk mempermudah proses penerimaan siswa baru secara digital. Dibangun dengan performa tinggi menggunakan backend **GoFiber** dan arsitektur RESTful API yang terstruktur, dikombinasikan dengan frontend Laravel.

</div>

---

## 📋 Daftar Isi
- [Tentang Sistem](#-tentang-sistem)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Fitur Utama](#-fitur-utama)
- [Stack Teknologi](#-stack-teknologi)
- [Skema Database](#-skema-database)
- [Prasyarat Instalasi](#-prasyarat-instalasi)
- [Panduan Instalasi](#-panduan-instalasi)
- [Rute API Utama](#-rute-api-utama)

---

## 🏢 Tentang Sistem
**Sistem Pendaftaran TK Aqila** dirancang untuk mendigitalkan dan mengotomatiskan proses penerimaan siswa baru. Sistem ini menggantikan formulir pendaftaran fisik dengan platform digital yang aman, cepat, dan mudah diakses oleh orang tua calon siswa maupun panitia pendaftaran (admin). 

Dengan pendekatan berbasis REST API, aplikasi memisahkan logika backend dan frontend sehingga memudahkan pengembangan di masa mendatang.

---

## 🏗 Arsitektur Sistem
```text
┌──────────────────────────────────────────────────────────────┐
│                       CLIENT APPLICATION                    │
│   ┌───────────────────┐      ┌────────────────────────────┐ │
│   │   User Frontend   │      │      Admin Dashboard       │ │
│   │   (Pendaftar)     │      │      (Panitia)             │ │
│   └────────┬──────────┘      └──────────┬─────────────────┘ │
└────────────┼─────────────────────────────┼───────────────────┘
             │          HTTP/JSON          │
┌────────────▼─────────────────────────────▼───────────────────┐
│                        GO BACKEND                            │
│                                                              │
│  Controllers (Handler)         Services (Business Logic)     │
│  (Auth, Pendaftaran, User)     (Validasi, Proses Data)       │
│                                                              │
│  Routes / Middleware           Repositories (Data Access)    │
│  (GoFiber, JWT Auth)           (GORM Query Builder)          │
└──────────────────────────────────┬───────────────────────────┘
                                   │
                      ┌────────────▼────────────┐
                      │     MySQL Database      │
                      │ users · pendaftar       │
                      │ dokumen · pengaturan    │
                      └─────────────────────────┘
```

---

## ✨ Fitur Utama

### 👥 Manajemen Pengguna & Pendaftar
- ✅ **Autentikasi (Login & Register)** — Akses terpisah antara Admin dan Orang Tua/Pendaftar.
- ✅ **Pengelolaan Data Diri Siswa** — Form pendaftaran lengkap yang divalidasi oleh sistem.
- ✅ **Upload Dokumen** — Mengunggah berkas syarat pendaftaran (Kartu Keluarga, Akta Kelahiran, dll).
- ✅ **Status Pendaftaran** — Tracking status penerimaan secara real-time.

### 🛡️ Keamanan & Validasi
- ✅ **JWT Authentication** — Keamanan endpoint API menggunakan JSON Web Token.
- ✅ **Password Hashing** — Penyimpanan kata sandi yang aman.
- ✅ **Validasi Payload** — Pengecekan data request untuk menghindari input tidak valid.

### 📊 Dashboard Admin (Panitia)
- ✅ **Overview Data** — Melihat jumlah pendaftar masuk, diverifikasi, dan ditolak.
- ✅ **Verifikasi Berkas** — Menyetujui atau menolak dokumen pendaftaran yang diunggah.
- ✅ **Manajemen Pengumuman** — Mengatur jadwal gelombang pendaftaran dan hasil seleksi.

---

## 💻 Stack Teknologi

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Bahasa Pemrograman** | Golang | Core language |
| **Web Framework** | GoFiber | Fast HTTP web framework |
| **Database** | MySQL | Relational database |
| **ORM** | GORM | Pemetaan model ke tabel database |
| **Authentication** | JWT | Token-based auth |

---

## 🗄️ Skema Database (Gambaran Singkat)

```sql
-- Pengguna Sistem (Orang Tua & Admin)
users
  id, name, email, password, role ('admin'|'user'), created_at, updated_at

-- Data Siswa / Pendaftar
pendaftar
  id, user_id, nama_lengkap, nik, tempat_lahir, tanggal_lahir, 
  jenis_kelamin, alamat, nama_ayah, nama_ibu, status_pendaftaran

-- Dokumen Pendukung
dokumen
  id, pendaftar_id, jenis_dokumen, file_url, status_verifikasi
```

*(Catatan: Sesuaikan struktur tabel ini dengan model aslinya di kode GORM Anda)*

---

## ⚙️ Prasyarat Instalasi

| Kebutuhan | Versi Minimum | Catatan |
| :--- | :---: | :--- |
| Golang | **1.20+** | Wajib untuk kompilasi |
| MySQL | **8.0+** | Server database lokal/remote |
| Git | **2.x** | Version control |

---

## 🚀 Panduan Instalasi

### 1 — Clone Repository
```bash
git clone https://github.com/username/web-pendaftaran-tkaqila.git
cd web-pendaftaran-tkaqila
```

### 2 — Install Dependencies Go
```bash
go mod tidy
```

### 3 — Konfigurasi Environment
Buat file konfigurasi `.env` pada root direktori:

```ini
APP_PORT=3000

DB_HOST=127.0.0.1
DB_PORT=3306
DB_USER=root
DB_PASSWORD=
DB_NAME=db_pendaftaran_tkaqila

JWT_SECRET=your_super_secret_key_here
```

### 4 — Jalankan Aplikasi
Aplikasi akan secara otomatis melakukan migrasi database (AutoMigrate dari GORM) saat dijalankan pertama kali.

```bash
# Menjalankan untuk development
go run main.go

# Atau jika menggunakan air (Live reload)
air
```
Aplikasi backend akan berjalan di `http://localhost:3000`.

Untuk cara menjalankan frontend Laravel, Go API, Vite, dan MCP secara lengkap, silakan lihat file `RUNNING.md`.

---

## 🛣️ Rute API Utama

Berikut adalah ringkasan beberapa endpoint yang tersedia.

| Method | Endpoint | Deskripsi | Auth |
| :--- | :--- | :--- | :---: |
| `POST` | `/api/register` | Mendaftarkan akun orang tua baru | — |
| `POST` | `/api/login` | Login untuk mendapatkan token JWT | — |
| `GET`  | `/api/pendaftar/me` | Melihat data pendaftaran milik sendiri | ✅ User |
| `POST` | `/api/pendaftar` | Mensubmit formulir pendaftaran | ✅ User |
| `GET`  | `/api/admin/pendaftar` | Mengambil seluruh data pendaftar | ✅ Admin |
| `PUT`  | `/api/admin/pendaftar/:id` | Mengubah status pendaftaran siswa | ✅ Admin |

---

---

## 👥 Kontributor & Pengembang

*   **Faris Zaky** ([@Rahwul](https://github.com/Rahwul)) — Rancang Bangun & Pengembang Utama Sistem.

---

<div align="center">

**Dibuat untuk memudahkan tata kelola pendaftaran siswa baru secara modern dan transparan.**

</div>
