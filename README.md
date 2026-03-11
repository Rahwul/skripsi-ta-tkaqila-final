## Rancang Bangun REST API Sistem Informasi Pendaftaran Online PAUD TK Aqila

Judul skripsi:

> **"Rancang Bangun REST API Sistem Informasi Pendaftaran Online PAUD TK Aqila Menggunakan GoFiber Framework dengan Metode Agile Studi Kasus di TK Aqila Kabupaten Bogor"**

Project ini membangun:

- **Backend REST API** dengan **Golang + GoFiber** (utama untuk logika bisnis dan akses data).
- **Frontend web** dengan **Laravel (Blade + Tailwind)** yang hanya berperan sebagai client yang mengonsumsi REST API.
- **Database** menggunakan **MySQL**.

Semua proses pendaftaran, pengelolaan data pendaftar, jadwal, dan laporan dikerjakan di backend Go dan diakses lewat endpoint JSON yang konsisten.

---

## Arsitektur singkat

- **Frontend (Laravel)**  
  Menyediakan halaman:
  - Landing page / home
  - Form pendaftaran peserta didik
  - Login admin
  - Dashboard admin
  - Daftar pendaftar, detail, ubah status
  - Laporan pendaftaran
  - Jadwal kelas

  Laravel tidak menyimpan logika bisnis utama, hanya:
  - Validasi form dasar.
  - Mengirim request HTTP ke backend Go.
  - Menyimpan token JWT admin di session.

- **Backend (GoFiber)** – folder `backend/`  
  Menyediakan REST API JSON:
  - Auth admin (register, login, profile).
  - CRUD pendaftaran (termasuk upload berkas).
  - Laporan pendaftaran per periode.
  - CRUD jadwal kelas.

  Struktur utama:
  - `backend/cmd/api/main.go` – entrypoint API.
  - `backend/config` – konfigurasi (APP_PORT, JWT_SECRET, DB\_*).
  - `backend/database` – koneksi MySQL + AutoMigrate.
  - `backend/models` – `Admin`, `Pendaftaran`, `BerkasPendaftaran`, `Jadwal`.
  - `backend/repositories` – akses database per entitas.
  - `backend/services` – logika bisnis.
  - `backend/handlers` – handler HTTP (controller).
  - `backend/middleware` – JWT auth.
  - `backend/utils` – helper JWT dan response JSON.
  - `backend/routes` – definisi route API.

- **Database (MySQL)**  
  Tabel utama:
  - `admins`
  - `pendaftarans`
  - `berkas_pendaftarans`
  - `jadwals`

Tabel-tabel ini dibuat otomatis oleh **GORM AutoMigrate** saat backend dijalankan pertama kali.

---

## Keselarasan tampilan (Landing vs Admin)

Secara UI, halaman admin sudah selaras dengan landing page karena:

- Sama-sama memakai Tailwind dari `resources/css/app.css` dan asset Vite yang sama.
- Palet warna brand konsisten:
  - Indigo: `#4F46E5`
  - Green: `#10B981`
  - Dark slate (footer/sidebar): `#111827`
- Pola komponen konsisten:
  - Card putih `rounded-2xl` + `border` + shadow lembut.
  - Aksi primer memakai indigo/green.

Catatan struktur:

- Halaman admin aktif berada di `resources/views/admin/*` dengan layout `resources/views/layouts/admin.blade.php`.
- File `resources/views/dashboard.blade.php` adalah tampilan lama dan tidak dipakai oleh route saat ini.

---

## Prasyarat

Pastikan sudah terpasang di mesin lokal:

- PHP 8.1+ dan Composer
- Node.js 18+ dan npm / pnpm
- Go 1.21+
- MySQL (atau MariaDB) berjalan secara lokal
- Git (opsional)

---

## Konfigurasi awal

### 1. Clone / buka project

Jika belum:

```bash
git clone <repo-ini>
cd web-pendaftaran-tkaqila
```

Jika sudah, cukup buka folder project ini di editor / Laragon.

### 2. Buat database MySQL

Masuk ke MySQL dan buat database:

```sql
CREATE DATABASE db_tk_aqila
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

### 3. Konfigurasi `.env` Laravel

Copy dari `.env.example` jika belum:

```bash
cp .env.example .env
```

Lalu ubah bagian database dan API di `.env`:

```env
APP_NAME="TK Aqila"
APP_ENV=local
APP_KEY=base64:... # jalankan php artisan key:generate jika belum
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tk_aqila
DB_USERNAME=root
DB_PASSWORD=        # isi jika MySQL pakai password

SESSION_DRIVER=database
QUEUE_CONNECTION=database

APP_PORT=3000
JWT_SECRET=supersecretjwt   # GANTI dengan string acak panjang untuk produksi

API_BASE_URL=http://localhost:3000
```

> Catatan: backend Go juga membaca variabel `DB_*`, `APP_PORT`, dan `JWT_SECRET` yang sama dari environment yang sama.

---

## Akun admin (untuk login ke panel admin)

Sistem ini tidak membuat admin default otomatis. Buat admin pertama kali melalui endpoint backend:

- Endpoint: `POST /api/admin/register`
- Body JSON (contoh):

```json
{
  "name": "Admin TK Aqila",
  "email": "admin@tkaqila.test",
  "password": "admin12345"
}
```

Contoh panggilan pakai `curl` (Windows PowerShell / CMD):

```bash
curl -X POST http://localhost:3000/api/admin/register ^
  -H "Content-Type: application/json" ^
  -d "{\"name\":\"Admin TK Aqila\",\"email\":\"admin@tkaqila.test\",\"password\":\"admin12345\"}"
```

Setelah itu login dari frontend:

- URL: `GET /login`
- Kredensial contoh:
  - Email: `admin@tkaqila.test`
  - Password: `admin12345`

### 4. Install dependency Laravel & frontend

Di root project:

```bash
composer install

# jika menggunakan npm
npm install

# atau jika menggunakan pnpm
pnpm install
```

### 5. Migrasi database Laravel (opsional tapi disarankan)

Laravel menggunakan database untuk session, queue, dan cache. Jalankan:

```bash
php artisan migrate
```

Ini akan menambahkan tabel Laravel (misalnya `migrations`, `sessions`, `jobs`, dsb.) ke dalam `db_tk_aqila`, berdampingan dengan tabel yang dibuat GORM (`admins`, `pendaftarans`, `berkas_pendaftarans`, `jadwals`).

---

## Menjalankan backend GoFiber

Backend berada di folder `backend/` dan memakai module Go utama `web-pendaftaran-tkaqila`.

### Jalankan langsung dengan `go run`

Di root project:

```bash
go run ./backend/cmd/api
```

Jika konfigurasi benar:

- Server akan berjalan di port yang ditentukan oleh `APP_PORT` (default `3000`).
- GORM akan melakukan AutoMigrate membuat tabel:
  - `admins`
  - `pendaftarans`
  - `berkas_pendaftarans`
  - `jadwals`

### Build binary (opsional)

```bash
go build -o tk-aqila-api ./backend/cmd/api
./tk-aqila-api
```

---

## Menjalankan frontend Laravel

Frontend berjalan terpisah dari backend tapi berada di project yang sama.

### 1. Generate `APP_KEY` jika belum

```bash
php artisan key:generate
```

### 2. Build asset frontend (dev)

```bash
npm run dev

# atau
pnpm dev
```

Untuk mode produksi:

```bash
npm run build
```

### 3. Jalankan server Laravel

Gunakan salah satu:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Atau gunakan virtual host Laragon (`http://web-pendaftaran-tkaqila.test`) jika sudah dikonfigurasi.

Pastikan `APP_URL` di `.env` sesuai dengan URL yang kamu pakai.

### Catatan penting (Laragon + Vite)

Jika halaman tampil “polos” (class Tailwind seperti `flex`, `grid`, `px-4` tidak berefek), hampir pasti asset Vite tidak ter-load (404).

Solusi yang paling aman:

- Jalankan via `php artisan serve` lalu akses `http://127.0.0.1:8000`.
- Atau pakai Virtual Host Laragon yang document root-nya mengarah ke folder `public/` (misalnya `web-pendaftaran-tkaqila.test`).

---

## Alur dasar penggunaan

1. **Jalankan backend Go** (`go run ./backend/cmd/api`) → API aktif di `http://localhost:3000`.
2. **Jalankan frontend Laravel** (`php artisan serve`) → UI aktif di `http://localhost:8000`.
3. **Register admin (sekali saja)**  
   - Panggil `POST /api/admin/register` via Postman atau halaman khusus (jika sudah ada di frontend).
4. **Login admin dari halaman Laravel**  
   - Halaman `/login` akan memanggil endpoint `POST /api/admin/login` di backend.
   - JWT token disimpan di session Laravel (`api_token`).
5. **Pendaftaran peserta (public)**  
   - Form `/pendaftaran` mengirim `POST /api/pendaftaran` ke backend (tanpa auth).
6. **Admin mengelola data**  
   - Dashboard admin dan halaman admin lain mengonsumsi endpoint protected dengan header:
     - `Authorization: Bearer <JWT_TOKEN>`
   - Fitur:
     - Lihat daftar pendaftar.
     - Lihat detail pendaftar.
     - Update data.
     - Update status (pending, diproses, diterima, ditolak).
     - Hapus data.
     - Upload berkas (jpg/png/pdf).
     - Laporan pendaftaran per periode.
     - CRUD jadwal kelas.

---

## Ringkasan endpoint utama

Semua endpoint mengembalikan JSON dengan format:

```json
{
  "success": true,
  "message": "Pesan",
  "data": {},
  "errors": null
}
```

Jika gagal:

```json
{
  "success": false,
  "message": "Pesan gagal",
  "data": null,
  "errors": {}
}
```

### Auth admin

- `POST /api/admin/register` – register admin baru.
- `POST /api/admin/login` – login, mengembalikan JWT.
- `GET /api/admin/profile` – profil admin (protected, JWT).

### Pendaftaran

- `POST /api/pendaftaran` – buat pendaftaran baru (public).
- `GET /api/pendaftaran` – list pendaftar (protected).
- `GET /api/pendaftaran/{id}` – detail pendaftar (protected).
- `PUT /api/pendaftaran/{id}` – update data pendaftar (protected).
- `PATCH /api/pendaftaran/{id}/status` – update status pendaftar (protected).
- `DELETE /api/pendaftaran/{id}` – hapus pendaftar (protected).
- `POST /api/pendaftaran/{id}/upload-berkas` – upload berkas (jpg/png/pdf) (protected, multipart/form-data).

### Laporan

- `GET /api/laporan?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD` – laporan pendaftaran per periode (protected).

### Jadwal

- `GET /api/jadwal` – list jadwal kelas (protected).
- `POST /api/jadwal` – buat jadwal baru (protected).
- `GET /api/jadwal/{id}` – detail jadwal (protected).
- `PUT /api/jadwal/{id}` – update jadwal (protected).
- `DELETE /api/jadwal/{id}` – hapus jadwal (protected).

---

## Catatan untuk demo/sidang

- Tekankan bahwa:
  - Laravel hanya sebagai **frontend client**.
  - Seluruh logika bisnis dan akses data ada di backend GoFiber.
  - Komunikasi antar layer menggunakan **REST API JSON** dan **JWT** untuk autentikasi admin.
- Untuk uji manual:
  - Gunakan Postman untuk memanggil endpoint backend langsung.
  - Gunakan browser untuk menunjukkan alur lengkap dari landing → pendaftaran → login admin → dashboard → manajemen data.
