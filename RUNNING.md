# Cara Menjalankan Project (Laravel + Go API + Vite + MCP)

Panduan ini merangkum **urutan menjalankan** semua bagian project **TK Aqila** di mesin lokal (Windows / Laragon).

---

## Prasyarat

- PHP 8.1+ dan [Composer](https://getcomposer.org/)
- Node.js 18+ dan npm
- Go 1.21+
- MySQL (misalnya via Laragon) berjalan
- (Opsional) Cursor dengan MCP — lihat bagian [MCP](#mcp-cursor)

---

## 1. Database MySQL

1. Nyalakan MySQL (Laragon: **Start All**).
2. Buat database sesuai konfigurasi backend Go, misalnya:

   ```sql
   CREATE DATABASE IF NOT EXISTS db_tk_aqila CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. User/password MySQL harus sama dengan yang kamu set di **environment untuk Go** (lihat bagian 2).

---

## 2. Backend REST API (Go Fiber)

Backend membaca **variabel lingkungan sistem** (`DB_HOST`, `DB_DATABASE`, `APP_PORT`, `JWT_SECRET`, dll.). Tidak wajib file `.env` khusus Go selama variabel tersebut sudah di-set sebelum `go run`.

**Variabel umum:**

| Variabel       | Contoh              | Keterangan        |
|----------------|---------------------|-------------------|
| `APP_PORT`     | `3000`              | Port API          |
| `DB_HOST`      | `127.0.0.1`         | Host MySQL        |
| `DB_PORT`      | `3306`              | Port MySQL        |
| `DB_USER` / `DB_USERNAME` | `root`   | User MySQL        |
| `DB_PASSWORD` / `DB_PASS` | (kosong) | Password MySQL |
| `DB_NAME` / `DB_DATABASE`   | `db_tk_aqila` | Nama database |
| `JWT_SECRET`   | string panjang acak | Untuk JWT admin   |

**Jalankan API** dari folder root project:

```powershell
cd C:\laragon\www\web-pendaftaran-tkaqila
go run ./backend/cmd/api
```

Biarkan terminal ini **tetap terbuka**. Cek di browser: `http://127.0.0.1:3000/` — harus ada respons JSON API.

---

## 3. Frontend Laravel

### Setup awal (sekali)

```powershell
cd C:\laragon\www\web-pendaftaran-tkaqila
composer install
```

Jika belum ada `.env`:

```powershell
copy .env.example .env
php artisan key:generate
```

Di file **`.env` Laravel**, pastikan:

- **`API_BASE_URL`** mengarah ke API Go (default di kode: `http://localhost:3000`). Contoh:

  ```env
  API_BASE_URL=http://127.0.0.1:3000
  ```

- Database Laravel untuk **session** (biasanya MySQL atau sqlite sesuai `.env`). Untuk `SESSION_DRIVER=database`, jalankan migrasi:

  ```powershell
  php artisan migrate
  ```

### Menjalankan Laravel

```powershell
php artisan serve
```

Buka aplikasi web di: **http://127.0.0.1:8000** (atau URL yang ditampilkan di terminal).

---

## 4. Vite (Tailwind / asset front-end)

Buka **terminal terpisah**:

```powershell
cd C:\laragon\www\web-pendaftaran-tkaqila
npm install
npm run dev
```

Biarkan proses ini jalan saat mengembangkan UI. Halaman diakses lewat **URL `php artisan serve`**, bukan hanya port Vite.

---

## 5. Menggunakan file .bat (Alternatif Windows)

Untuk pengembangan sehari-hari, Anda bisa menjalankan dalam 3 terminal terpisah menggunakan file `.bat` yang disediakan:

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

---

## Ringkasan: apa yang harus jalan bersamaan

| Layanan    | Perintah / catatan                                      |
|------------|---------------------------------------------------------|
| MySQL      | Laragon / service MySQL aktif, database sudah dibuat      |
| Go API     | `go run ./backend/cmd/api` → port **3000** (default)    |
| Laravel    | `php artisan serve` → biasanya **8000**                   |
| Vite       | `npm run dev`                                           |

---

## MCP (Cursor)

MCP memanggil API Go yang sama; **API Go harus sudah jalan** saat tool MCP dipakai.

### Build server MCP (sekali atau setelah ubah kode MCP)

```powershell
cd C:\laragon\www\web-pendaftaran-tkaqila\mcp-server
npm install
npm run build
```

Harus ada file: `mcp-server\dist\index.js`.

### Konfigurasi Cursor

File global (contoh Windows): **`C:\Users\<username>\.cursor\mcp.json`**

Contoh isi:

```json
{
  "mcpServers": {
    "tkaqila-api": {
      "command": "node",
      "args": [
        "C:/laragon/www/web-pendaftaran-tkaqila/mcp-server/dist/index.js"
      ],
      "env": {
        "TK_AQILA_API_BASE_URL": "http://127.0.0.1:3000",
        "TK_AQILA_API_JWT": ""
      }
    }
  }
}
```

Sesuaikan path `args` jika folder project kamu berbeda.

- **`TK_AQILA_API_JWT`**: kosongkan untuk tool publik (`api_health`, `site_content_list`). Untuk daftar pendaftaran / jadwal / laporan, isi token dari `POST /api/admin/login`, lalu **restart Cursor**.
- **Jangan** jalankan `node dist/index.js` manual untuk pemakaian normal — Cursor yang menjalankan proses MCP.

Detail tool dan keamanan: [`mcp-server/README.md`](mcp-server/README.md).

---

## Troubleshooting singkat

| Masalah | Tindakan |
|---------|----------|
| Port 3000 sudah dipakai | Hentikan proses Go lain atau ubah `APP_PORT` + `API_BASE_URL` + env MCP |
| Laravel error session / migrate | `php artisan migrate` |
| CSS tidak berubah | Pastikan `npm run dev` jalan; hard refresh browser (`Ctrl+F5`) |
| MCP tidak connect | Pastikan `npm run build` di `mcp-server`, path di `mcp.json` benar, restart Cursor |
| Native binding Vite error | Jalankan `npm i -D @tailwindcss/oxide-win32-x64-msvc` |

---

## Dokumentasi tambahan

- Arsitektur & setup lengkap: [`README.md`](README.md)
