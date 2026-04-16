## Cara Menjalankan Proyek TK Aqila (Lokal)

### 1. Prasyarat

- **PHP**: 8.2 atau lebih baru (Laragon sudah menyediakannya).
- **Composer**: sudah terpasang (cek dengan `composer --version`).
- **Node.js**: minimal Node 20 (disarankan Node 22).
- **MySQL / MariaDB**: service berjalan di `127.0.0.1:3306`.
- **Go**: dibutuhkan untuk backend API (belum terpasang di mesin ini saat terakhir dicek).

> Jika Go belum terinstal, Anda masih bisa membuka tampilan frontend, tetapi halaman yang memanggil API (login admin, dashboard, dsb.) tidak akan berfungsi penuh sampai backend Go dijalankan.

---

### 2. Setup awal (sekali saja)

Jalankan perintah ini di root project (`web-pendaftaran-tkaqila`):

```bash
cd C:\laragon\www\web-pendaftaran-tkaqila\web-pendaftaran-tkaqila
```

#### 2.1. Buat file `.env` (jika belum ada)

Project ini sudah saya buatkan `.env` contoh dengan konfigurasi lokal berikut:

```env
APP_NAME="TK Aqila"
APP_ENV=local
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tk_aqila
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database

APP_PORT=3000
JWT_SECRET=tk_aqila_local_secret_2026_change_for_production
API_BASE_URL=http://127.0.0.1:3000
```

Jika ingin mengubah nama database atau password MySQL, sesuaikan bagian `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.

#### 2.2. Install dependency

```bash
# PHP / Laravel
composer install

# Frontend (Vite + Tailwind)
npm install
```

Jika saat build/dev muncul error terkait Tailwind/Vite native binding (misalnya `Cannot find native binding`), berarti Node yang dipakai masih terlalu lama. Solusi cepat:

```bash
npm i -D @tailwindcss/oxide-win32-x64-msvc
```

#### 2.3. Generate APP_KEY dan migrasi database Laravel

```bash
php artisan key:generate
php artisan migrate --force
```

Pastikan database `db_tk_aqila` sudah ada. Jika belum, buat lewat MySQL:

```sql
CREATE DATABASE db_tk_aqila
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

#### 2.4. Build asset frontend (opsional untuk production)

```bash
npm run build
```

Untuk pengembangan nanti cukup `npm run dev` (lihat bagian bawah).

---

### 3. Menjalankan backend Go (API)

> Langkah ini hanya bisa dilakukan setelah **Go** terinstal dan tersedia di `PATH` (cek dengan `go version`).

1. Pastikan variabel environment sesuai dengan `.env`:
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - `APP_PORT` (default 3000)
   - `JWT_SECRET`

   Di lingkungan pengembangan dengan Laragon, cukup pastikan `.env` sudah benar; backend membaca nilai yang sama.

2. Jalankan backend dari root project:

   ```bash
   go run ./backend/cmd/api
   ```

3. Jika berhasil:
   - API akan aktif di `http://127.0.0.1:3000`
   - Log akan menampilkan pesan serupa: `Server berjalan di port 3000`
   - GORM akan otomatis membuat tabel: `admins`, `pendaftarans`, `berkas_pendaftarans`, `jadwals`, `site_contents`

---

### 4. Menjalankan frontend Laravel

#### 4.1. Jalankan Vite (dev)

Di terminal pertama:

```bash
cd C:\laragon\www\web-pendaftaran-tkaqila\web-pendaftaran-tkaqila
npm run dev
```

Biasanya Vite akan berjalan di `http://127.0.0.1:5173` dan akan di-proxy oleh Laravel Vite plugin untuk file asset.

#### 4.2. Jalankan server Laravel

Di terminal kedua:

```bash
cd C:\laragon\www\web-pendaftaran-tkaqila\web-pendaftaran-tkaqila
php artisan serve --host=127.0.0.1 --port=8000
```

Lalu buka di browser:

```text
http://127.0.0.1:8000
```

Jika menggunakan virtual host Laragon, Anda bisa mengarahkannya ke folder `public/` dan menyesuaikan `APP_URL` di `.env`.

---

### 5. Urutan run lengkap (recommended)

Untuk pengembangan sehari-hari, jalankan dalam 3 terminal terpisah:

1. **Backend Go (API)**
   Jalankan file `run-go-api.bat`:
   ```bash
   run-go-api.bat
   ```

2. **Vite dev server**
   Jalankan file `run-vite-dev.bat`:
   ```bash
   run-vite-dev.bat
   ```

3. **Laravel server**
   Jalankan file `run-laravel-serve.bat`:
   ```bash
   run-laravel-serve.bat
   ```

Frontend akan mengonsumsi API di `http://127.0.0.1:3000` sesuai konfigurasi `API_BASE_URL` pada `.env`.

---

### 6. Catatan masalah umum

- **Halaman tampil polos (tanpa Tailwind)**  
  - Cek apakah `npm run dev` sedang berjalan.
  - Cek console browser apakah ada error `404` pada asset `public/build` atau script Vite.

- **Login admin / dashboard error**  
  - Pastikan backend Go sudah berjalan (tes `http://127.0.0.1:3000/` atau endpoint `/api/...`).
  - Pastikan `API_BASE_URL` di `.env` mengarah ke `http://127.0.0.1:3000`.

- **Koneksi database gagal**  
  - Cek service MySQL di Laragon sudah menyala.
  - Cek `DB_*` di `.env` dan pastikan database `db_tk_aqila` sudah dibuat.

