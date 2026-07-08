# 📖 Panduan Pemeliharaan (Maintenance) & Update Server - TK Aqila

Dokumen ini berisi panduan lengkap untuk mengakses server (VPS), melakukan pemeliharaan rutin, serta melakukan update kode program (frontend & backend) pada website **TK Aqila**.

---

## 🔑 1. Tata Cara Masuk ke Server (SSH)

Server website TK Aqila berjalan di VPS Ubuntu dengan alamat IP **`103.235.72.55`**.

Untuk masuk ke server, gunakan berkas private key **`syahdu.pem`** yang ada di komputer Anda.

### Cara Masuk lewat PowerShell/Terminal:
Buka PowerShell atau Command Prompt di komputer Anda, lalu jalankan perintah berikut:
```powershell
ssh -i C:\Users\muzak\.ssh\syahdu.pem root@103.235.72.55
```

> [!TIP]
> Jika Anda berada di Linux atau macOS, pastikan file key memiliki hak akses yang aman sebelum melakukan koneksi:
> `chmod 400 /path/to/syahdu.pem`

---

## 🛠️ 2. Informasi Pemeliharaan (Maintenance)

Berikut adalah beberapa perintah penting untuk memantau status aplikasi, restart layanan, dan memantau log jika terjadi error.

### A. Memantau Status & Mengontrol Go API (Backend)
Backend Go dijalankan sebagai layanan latar belakang menggunakan **Systemd** dengan nama layanan `tkaqila-api`.

* **Cek status running Go API:**
  ```bash
  systemctl status tkaqila-api
  ```
* **Restart Go API (jika ada perubahan/macet):**
  ```bash
  systemctl restart tkaqila-api
  ```
* **Menghentikan Go API:**
  ```bash
  systemctl stop tkaqila-api
  ```
* **Memulai Go API:**
  ```bash
  systemctl start tkaqila-api
  ```

### B. Memantau Log Error (Debugging)
Jika website mengalami error, Anda bisa membaca log aktivitas langsung melalui server:

* **Log Go API (Backend):**
  ```bash
  journalctl -u tkaqila-api -n 100 --no-pager
  # Tambahkan -f jika ingin memantau log secara real-time:
  journalctl -u tkaqila-api -f
  ```
* **Log Laravel (Frontend):**
  ```bash
  tail -n 100 /var/www/web-pendaftaran-tkaqila/storage/logs/laravel.log
  ```
* **Log Error Nginx (Web Server):**
  ```bash
  tail -n 50 /var/log/nginx/error.log
  ```

### C. Backup Database MySQL/MariaDB
Untuk mengamankan data pendaftaran siswa, disarankan melakukan backup database secara berkala:
```bash
mysqldump -u root db_tk_aqila > /root/backup_db_tk_aqila_$(date +%F).sql
```
*(Hasil backup berupa file `.sql` akan tersimpan di direktori `/root` server).*

---

## 🚀 3. Tata Cara Update Konten / Update Kode Website

Jika Anda melakukan perubahan kode di komputer lokal, lakukan push ke GitHub terlebih dahulu. Setelah itu, ikuti langkah-langkah berikut di dalam server untuk memperbarui website live:

### Langkah 1: Masuk ke Server dan Folder Project
```bash
ssh -i C:\Users\muzak\.ssh\syahdu.pem root@103.235.72.55
cd /var/www/web-pendaftaran-tkaqila
```

### Langkah 2: Ambil Kode Terbaru dari Git (Pull)
```bash
git pull origin main
```

### Langkah 3: Update Laravel Frontend (Jika ada perubahan Frontend)
Jika Anda mengubah file `.blade.php`, Controller Laravel, atau aset CSS/JS:
1. **Instal dependensi baru (jika ada):**
   ```bash
   export COMPOSER_ALLOW_SUPERUSER=1
   composer install --no-dev --optimize-autoloader
   ```
2. **Kompilasi aset CSS & JS baru dengan Vite:**
   ```bash
   # Hapus package-lock jika bentrok platform
   rm -f package-lock.json 
   npm install
   npm run build
   ```
3. **Jalankan migrasi database (jika ada perubahan struktur tabel):**
   ```bash
   php artisan migrate --force
   ```
4. **Bersihkan cache Laravel agar config baru terbaca:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   # Atur ulang permission folder storage agar tidak error 500
   chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

### Langkah 4: Update Go API Backend (Jika ada perubahan file di folder `backend/`)
Karena Go adalah bahasa yang dicompile, Anda bisa mencampurnya dengan melakukan cross-compile di komputer lokal terlebih dahulu agar tidak membebani memori VPS:

1. **Jalankan perintah ini di PowerShell Komputer Lokal Anda (dalam folder project):**
   ```powershell
   # Compile untuk linux target
   $env:GOOS="linux"
   $env:GOARCH="amd64"
   go build -ldflags="-s -w" -o backend-api-linux ./backend/cmd/api
   
   # Transfer biner baru ke VPS
   scp -i C:\Users\muzak\.ssh\syahdu.pem .\backend-api-linux root@103.235.72.55:/var/www/web-pendaftaran-tkaqila/backend-api
   ```
2. **Jalankan perintah ini di dalam SSH VPS Anda:**
   ```bash
   # Beri akses execute ke biner baru
   chmod +x /var/www/web-pendaftaran-tkaqila/backend-api
   
   # Restart service API agar biner baru berjalan
   systemctl restart tkaqila-api
   ```

---

## 🔒 4. Informasi Konfigurasi Tambahan

### A. Lokasi Konfigurasi Web Server (Nginx)
File konfigurasi virtual host Nginx untuk mengatur domain berada di:
👉 `/etc/nginx/sites-available/tkaqila.my.id`

* **Cek apakah konfigurasi Nginx ada error:**
  ```bash
  nginx -t
  ```
* **Reload Nginx setelah mengedit konfigurasi:**
  ```bash
  systemctl reload nginx
  ```

### B. File Environment (.env) Laravel
Berisi kredensial database dan API endpoint. Jika ingin mengubah konfigurasi database atau URL API, edit file ini:
👉 `/var/www/web-pendaftaran-tkaqila/.env`
