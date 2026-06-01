# 📖 Panduan Belajar Menjalankan Project - TK Aqila
Halo **Rahwul**! Panduan ini khusus dibuat untuk membantu kamu memahami seluruh struktur, alur kerja, dan cara menjalankan project **TK Aqila** (Laravel + Go API + Vite) di komputer lokal kamu dengan mudah.

---

## 🛠️ Prasyarat Sebelum Mulai
Sebelum menjalankan aplikasi, pastikan komputer/laptop kamu sudah terinstall software berikut:
1. **Laragon / XAMPP:** Untuk menyalakan MySQL Database.
2. **PHP 8.1+ & Composer:** Untuk menjalankan Laravel.
3. **Go (Golang) 1.21+:** Untuk menjalankan Backend API.
4. **Node.js (LTS):** Untuk mengompilasi tampilan (Vite/Tailwind).

---

## ⚡ Cara Cepat Menjalankan Aplikasi (1-Klik!)
Agar kamu tidak perlu repot membuka banyak terminal dan mengetik perintah satu per satu, kami sudah menyediakan script otomatis di folder ini.

1. Buka aplikasi **Laragon** kamu, lalu klik **Start All** untuk menyalakan MySQL database.
2. Buka folder ini di Windows Explorer dan **Double-Click (Klik Dua Kali)** berkas:
   👉 **`run_all.bat`**
3. Script otomatis akan langsung membuka 3 jendela Command Prompt (CMD) terpisah di latar belakang:
   * 🖥️ **CMD 1:** Menjalankan **Go API Backend** (Port `3000`)
   * 🖥️ **CMD 2:** Menjalankan **Laravel Server** (Port `8000`)
   * 🖥️ **CMD 3:** Menjalankan **Vite Asset Compiler** (Port `5173`)
4. Buka Browser kamu dan masuk ke alamat:
   👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🧭 Cara Manual (Jika Ingin Belajar Menggunakan Terminal)
Jika kamu ingin belajar menjalankan satu per satu lewat terminal/VS Code, berikut adalah langkah-langkahnya:

### 1. Menjalankan Backend API (Go Fiber)
Buka terminal baru di root folder project, lalu ketik perintah berikut:
```powershell
go run ./backend/cmd/api
```
* **Keterangan:** Ini akan menjalankan API di `http://127.0.0.1:3000`. Biarkan terminal ini tetap terbuka.

### 2. Menjalankan Server Laravel (PHP)
Buka terminal terpisah kedua, lalu jalankan perintah:
```powershell
php artisan serve
```
* **Keterangan:** Ini melayani frontend web utama di `http://127.0.0.1:8000`.

### 3. Menjalankan Vite Dev Server (Asset Frontend)
Buka terminal terpisah ketiga, lalu jalankan perintah:
```powershell
npm run dev
```
* **Keterangan:** Ini memantau perubahan file CSS/JS dan melakukan kompilasi otomatis.

---

## 🔑 Kredensial Login Admin
Untuk masuk ke panel pengelolaan pendaftaran TK Aqila, kamu bisa menggunakan akun admin default yang sudah terdaftar di database lokal:

* **Halaman Login:** [http://127.0.0.1:8000/loginadmin](http://127.0.0.1:8000/loginadmin)
* **Email:** `admin_test_1@example.com`
* **Password:** `admin12345`

---

## ➕ Cara Membuat Akun Admin Baru
Jika database kamu di-reset dan kamu ingin mendaftarkan akun admin baru, jalankan perintah ini di **PowerShell** kamu:

```powershell
$body='{"name":"Admin Baru","email":"admin_baru@example.com","password":"admin12345"}'
Invoke-RestMethod -Uri "http://127.0.0.1:3000/api/admin/register" -Method Post -ContentType "application/json" -Body $body
```

---

## 🔧 Solusi Masalah Umum (Troubleshooting)

### 1. Pesan Error: "Cannot POST /api/auth/login" saat Login
* **Penyebab:** Endpoint login di dokumentasi lama salah mengarah ke `/api/auth/login`.
* **Solusi:** Kami sudah memperbaiki kode di Laravel untuk mengarah ke endpoint yang benar di Go API, yaitu `/api/admin/login`. Pastikan browser kamu di-refresh (`Ctrl + F5`) sebelum login kembali.

### 2. Mengisi Ulang Tabel Database (Migrasi Ulang)
Jika database kamu kosong atau kamu ingin merapikan tabel Laravel untuk session, jalankan perintah:
```powershell
php artisan migrate
```

### 3. Port Terpakai (Port Already in Use)
Jika kamu mendapat error port `3000` atau `8000` sudah terpakai:
* Cari aplikasi Go atau Laravel lain yang masih berjalan dan tutup terminalnya.
* Atau kamu bisa me-restart komputer/laptop untuk mematikan proses background yang menggantung.

---

Selamat belajar, **Rahwul**! Semoga sukses menyusun skripsi dan tugas akhir ini. Jika ada kode yang membingungkan, jangan ragu untuk bertanya! 🚀
