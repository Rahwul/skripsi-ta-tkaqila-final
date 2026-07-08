# 📖 Panduan Pengujian REST API menggunakan Postman - TK Aqila

Halo **Rahwul**! Panduan ini dibuat secara rinci untuk membantu kamu melakukan pengujian **REST API (Backend Go)** yang telah dibuat menggunakan aplikasi **Postman**. Panduan ini mencakup semua skenario pengujian yang ditulis di **BAB IV Skripsi** (T01 s.d. T11).

---

## 🛠️ Langkah 1: Persiapan & Instalasi Postman

1. **Unduh Postman:**
   Download versi desktop aplikasi Postman di link resmi: [https://www.postman.com/downloads/](https://www.postman.com/downloads/)
2. **Instalasi:**
   Jalankan file `.exe` yang sudah diunduh dan ikuti proses instalasinya sampai selesai. Kamu bisa login/sign up gratis atau memilih "Skip and go to the app".
3. **Pastikan API Go Sudah Berjalan:**
   Sebelum mencoba di Postman, jalankan database MySQL (Laragon) dan API Go kamu.
   * Cara cepat: Double-click berkas `run_all.bat` di folder root project.
   * Alamat default API lokal: `http://127.0.0.1:3000`

---

## 🌐 Langkah 2: Membuat Environment & Collection di Postman

Agar tidak perlu mengetik alamat `http://127.0.0.1:3000` berulang kali, ikuti langkah berikut:

### 1. Membuat Collection
1. Buka Postman, klik menu **Collections** di sebelah kiri.
2. Klik tombol **`+`** (Create new collection), lalu beri nama: **`API TK Aqila - Backend Go`**.

### 2. Membuat Environment Variable (Opsional tapi Sangat Disarankan)
1. Klik menu **Environments** di sebelah kiri.
2. Klik tombol **`+`** (Create environment), beri nama: **`Lokal`**.
3. Di dalam tabel, tambahkan baris baru:
   * **Variable:** `baseURL`
   * **Type:** `default`
   * **Initial Value:** `http://127.0.0.1:3000`
   * **Current Value:** `http://127.0.0.1:3000`
4. Klik **Save** (Ctrl + S) di kanan atas.
5. Aktifkan environment ini dengan memilih dropdown di pojok kanan atas Postman dari "No Environment" menjadi **`Lokal`**.
6. Sekarang kamu bisa menulis URL request cukup dengan: `{{baseURL}}/api/...`

---

## 🧪 Langkah 3: Pengujian Skenario API (T01 s.d. T11)

Berikut adalah panduan detail untuk melakukan pengetesan masing-masing endpoint di Postman:

### 📑 Bagian A: Autentikasi Admin (Tanpa Proteksi Token)

#### T01: Registrasi Admin Baru (`POST`)
* **URL:** `{{baseURL}}/api/admin/register`
* **Method:** `POST`
* **Tab Body:** Pilih **raw** dan ubah format dropdown ke **JSON**.
* **Payload JSON:**
  ```json
  {
    "name": "Admin Rahwul",
    "email": "rahwul@example.com",
    "password": "adminpassword123"
  }
  ```
* **Hasil yang Diharapkan:** HTTP Status `201 Created` dengan balasan detail data user baru.
* *Catatan:* Jika kamu menembak URL ini dua kali dengan email yang sama, sistem akan membalas dengan `400 Bad Request` (menguji validasi email unik).

#### T02 & T03: Login Admin (`POST`)
* **URL:** `{{baseURL}}/api/admin/login`
* **Method:** `POST`
* **Tab Body:** Pilih **raw** -> **JSON**.
* **Payload JSON (Login Sukses - T02):**
  ```json
  {
    "email": "rahwul@example.com",
    "password": "adminpassword123"
  }
  ```
* **Hasil yang Diharapkan:** HTTP Status `200 OK` dengan respons data token JWT (simpan string token ini untuk langkah berikutnya).
* **Payload JSON (Login Gagal - T03):**
  ```json
  {
    "email": "rahwul@example.com",
    "password": "password_salah_kamu"
  }
  ```
* **Hasil yang Diharapkan:** HTTP Status `401 Unauthorized`.

---

### 📑 Bagian B: Menggunakan Token JWT di Postman (Sangat Penting!)

Beberapa API di bawah dilindungi oleh **Middleware JWT**. Jika kamu langsung menembaknya tanpa menyertakan token, kamu akan mendapatkan error `401 Unauthorized` (Skenario T11).

**Cara memasang token JWT di Postman:**
1. Klik tab **Authorization** pada Request kamu.
2. Di dropdown **Type**, pilih **Bearer Token**.
3. Di sebelah kanan pada kolom **Token**, tempelkan (paste) string token panjang hasil dari API Login (T02).
4. Klik **Send**.

---

### 📑 Bagian C: Endpoint Manajemen Pendaftaran Calon Siswa

#### T04 & T05: Kirim Pendaftaran Baru (`POST`)
* **URL:** `{{baseURL}}/api/pendaftaran`
* **Method:** `POST`
* **Tab Body:** Pilih **raw** -> **JSON**.
* **Payload JSON (Sukses - T04):**
  ```json
  {
    "nama_anak": "Muzaki Abdullah Irsyad",
    "tempat_lahir": "JAKARTA",
    "tanggal_lahir": "2026-06-14",
    "jenis_kelamin": "L",
    "nama_orang_tua": "Faris",
    "no_hp": "08871627843",
    "alamat": "Jl. Manunggal RT. 005 RW.02 NO.89 KEL. MAKASAR KEC MAKASAR JAKARTA TIMUR 13570",
    "catatan": "Keterangan opsional"
  }
  ```
* **Hasil yang Diharapkan:** HTTP Status `201 Created` dengan respons detail pendaftaran beserta `"id"` pendaftar (catat `"id"` ini untuk test upload berkas).
* **Payload JSON (Error Validasi - T05):**
  Kosongkan salah satu kolom wajib, misal `"nama_anak"` dihapus:
  ```json
  {
    "nama_anak": "",
    "tempat_lahir": "JAKARTA"
  }
  ```
* **Hasil yang Diharapkan:** HTTP Status `400 Bad Request` dengan list error validasi kolom.

#### T06: Upload Berkas Calon Siswa (`POST`)
* **URL:** `{{baseURL}}/api/pendaftaran/1/upload-berkas` (ganti angka `1` sesuai ID pendaftar yang didapat dari T04).
* **Method:** `POST`
* **Tab Body:** Pilih **form-data** (bukan raw/JSON).
* **Tabel parameter form-data:**
  1. **Key:** `jenis_berkas` | **Value:** `kartu_keluarga` (tipe teks)
  2. **Key:** `file` | **Value:** (Arahkan kursor ke ujung kanan kolom key `file`, ubah dropdown tipe data dari **Text** menjadi **File**, lalu klik **Select Files** untuk mengunggah gambar/PDF berkas latihan dari komputer kamu).
* **Hasil yang Diharapkan:** HTTP Status `201 Created`.

#### T07: Lihat Semua Data Pendaftaran (`GET`)
* **URL:** `{{baseURL}}/api/pendaftaran`
* **Method:** `GET`
* **Autentikasi:** Wajib centang tab **Authorization** -> **Bearer Token** -> isi Token JWT.
* **Hasil yang Diharapkan:** HTTP Status `200 OK` yang mengembalikan array objek pendaftaran siswa.

#### T08: Update Status Pendaftaran (`PATCH`)
* **URL:** `{{baseURL}}/api/pendaftaran/1/status` (ubah `1` ke ID pendaftar yang ingin diubah).
* **Method:** `PATCH`
* **Autentikasi:** Wajib **Bearer Token**.
* **Tab Body:** Pilih **raw** -> **JSON**.
* **Payload JSON:**
  ```json
  {
    "status_pendaftaran": "diterima"
  }
  ```
  *(Opsi status yang valid: `pending`, `diproses`, `diterima`, `ditolak`)*
* **Hasil yang Diharapkan:** HTTP Status `200 OK` dengan status baru yang berhasil diperbarui di DB.

#### T09: Hapus Data Pendaftar (`DELETE`)
* **URL:** `{{baseURL}}/api/pendaftaran/1` (ubah `1` ke ID pendaftar yang ingin dihapus).
* **Method:** `DELETE`
* **Autentikasi:** Wajib **Bearer Token**.
* **Hasil yang Diharapkan:** HTTP Status `200 OK` ("Pendaftaran berhasil dihapus").

#### T10: Mengambil Laporan Periode (`GET`)
* **URL:** `{{baseURL}}/api/laporan?start_date=2026-01-01&end_date=2026-12-31`
* **Method:** `GET`
* **Autentikasi:** Wajib **Bearer Token**.
* **Hasil yang Diharapkan:** HTTP Status `200 OK` dengan rekap data pendaftaran pada range tanggal tersebut.

---

## 📺 Referensi Video Belajar Postman (YouTube Bahasa Indonesia)

Bagi kamu yang ingin memahami Postman secara visual, berikut adalah rekomendasi video pembelajaran terbaik dari YouTube dalam Bahasa Indonesia:

1. **[Dasar Pengujian API menggunakan Postman - ngetest.id](https://www.youtube.com/watch?v=R8ea2uqiwmk)**
   * **Deskripsi:** Video ini membahas instalasi, pengenalan antarmuka (UI), membuat request, menggunakan Collection, serta menggunakan Environment Variables. Sangat cocok sebagai panduan awal.
2. **[Playlist Lengkap Belajar Postman - Bincang QA](https://www.youtube.com/playlist?list=PLteNxiEnsdrR1vz9CiZBTXVX98BD6BEKg)**
   * **Deskripsi:** Seri video lengkap yang membahas pengujian API secara bertahap untuk pemula, termasuk assertions (validasi otomatis respon) dan tips mengelompokkan request.
3. **[Tutorial Mengakses Open API dengan Postman - Programmer Zaman Now](https://www.youtube.com/watch?v=y6dO8i945xY)**
   * **Deskripsi:** Panduan interaktif cara mempraktekkan berbagai macam HTTP Methods (GET, POST, PATCH, DELETE) pada API nyata.

---

## 📤 Cara Ekspor Collection untuk Lampiran Sidang / Penguji
Jika kamu ingin melampirkan file konfigurasi pengujian Postman ini di CD Skripsi atau membagikannya ke penguji:
1. Klik tanda titik tiga (`...`) di samping kanan nama Collection **API TK Aqila - Backend Go**.
2. Pilih **Export**.
3. Pilih format rekomendasi (**Collection v2.1**), lalu klik **Export** dan simpan di komputer kamu dengan format nama file `API_TK_Aqila.postman_collection.json`.
4. File JSON tersebut bisa di-import langsung oleh penguji di aplikasi Postman mereka untuk mencoba sistem kamu.

Semoga panduan ini membantu kelancaran penulisan skripsi dan demonstrasi aplikasi kamu saat sidang nanti! 🚀
