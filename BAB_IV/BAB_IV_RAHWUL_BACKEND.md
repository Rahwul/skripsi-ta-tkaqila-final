# BAB IV
# IMPLEMENTASI DAN PENGUJIAN SISTEM (BACK END - RAHWUL)

Bab ini menjelaskan tahapan implementasi dari rancangan arsitektur *Back End* (REST API) dan basis data, serta pengujian teknis yang dilakukan pada *server-side* untuk memastikan logika sistem, keamanan, dan pengelolaan data berjalan sesuai spesifikasi yang telah ditentukan.

## 4.1 Perancangan Sistem Back End

### 4.1.1 Arsitektur Sistem dan Basis Data
Sistem *Back End* dibangun menggunakan arsitektur REST API dengan pemisahan *layer* yang jelas antara *Controller*, *Middleware* (untuk validasi keamanan), dan *Repository* (untuk akses database). Manajemen struktur data dipetakan menggunakan *Object-Relational Mapping* (ORM) yang mempresentasikan entitas-entitas seperti `users`, `students`, `classes`, dan `registrations`.

*(Catatan: Anda dapat menyisipkan gambar `rahwul_architecture.png` dan `system_class.png` di sini)*

### 4.1.2 Pemodelan Alur Logika (UML)
Pemodelan logika di sisi peladen (*server*) dipetakan ke dalam UML:
1. **Use Case Diagram**: Menggambarkan berbagai *Endpoint API* (seperti `POST /students` atau `POST /auth/login`) yang disediakan *Back End* untuk digunakan oleh *Client App*.
2. **Activity Diagram**: Menggambarkan proses di belakang layar, misal: saat sistem memverifikasi *email*, membandingkan *password hash*, lalu men-*generate* JWT.
3. **Sequence Diagram**: Memvisualisasikan lalu lintas data ketika *Request* API masuk, divalidasi oleh *Middleware*, diproses *Handler*, hingga *query SQL* disematkan ke MySQL via GORM.

*(Catatan: Anda dapat menyisipkan gambar `rahwul_usecase.png`, `rahwul_activity.png`, dan `rahwul_sequence.png` di sini)*

## 4.2 Implementasi Sistem Back End

*Back End* diimplementasikan menggunakan bahasa pemrograman **Golang (Go)** dengan *framework* **GoFiber** yang terkenal dengan performa *routing* yang sangat cepat. Penyimpanan data utama menggunakan sistem RDBMS **MySQL**.
Penyimpanan *password* diamankan menggunakan metode enkripsi satu arah (*Hashing*) dengan *algoritma Bcrypt*, sementara mekanisme otentikasi diimplementasikan berbasis *stateless* menggunakan **JSON Web Token (JWT)**.

## 4.3 Evaluasi dan Pengujian Sistem Terperinci

Pengujian di sisi *Back End* sepenuhnya difokuskan pada pengujian kotak hitam (*Black Box Testing*) berbasis API untuk menguji respons kode HTTP, serta pengujian keamanan *Middleware*. Pengujian ini dilakukan menggunakan perangkat lunak **Postman**.

### 4.3.1 Pengujian Fungsionalitas API Endpoint (Postman)
Skenario pengujian menguji keandalan setiap URL *endpoint* dalam memproses format JSON yang benar maupun salah.

| No | Endpoint (Route) | Method | Skenario Pengujian Parameter (Payload JSON) | Hasil yang Diharapkan (HTTP Status) | Hasil Aktual (Di Postman) | Status |
|---|---|---|---|---|---|---|
| 1 | `/api/auth/register` | POST | Mengirim data nama, email unik, dan password baru | Sistem mencatat ke DB, merespon dengan JSON Success (201 Created) | 201 Created | **Valid** |
| 2 | `/api/auth/register` | POST | Mendaftar ulang dengan *email* yang sudah ada di database | Sistem mendeteksi duplikat, merespon pesan "Email already exists" (409 Conflict) | 409 Conflict | **Valid** |
| 3 | `/api/auth/login` | POST | Mengirim *email* dan *password* yang cocok dengan DB | Sistem men-*generate* JWT dan mengembalikannya (200 OK) | 200 OK (Token Generated) | **Valid** |
| 4 | `/api/auth/login` | POST | Mengirim *password* yang sengaja disalahkan | Sistem menolak dengan pesan "Invalid credentials" (401 Unauthorized) | 401 Unauthorized | **Valid** |
| 5 | `/api/students` | POST | Mengirim payload registrasi siswa baru dengan validasi data lengkap | Data siswa dan relasi pendaftaran disimpan (201 Created) | 201 Created | **Valid** |
| 6 | `/api/students` | GET | Admin *request* URL untuk mengambil seluruh daftar anak didik | Mengembalikan Array JSON berisi data pendaftar (200 OK) | 200 OK | **Valid** |
| 7 | `/api/students/status` | PUT | Mengirim request untuk mengubah status pendaftar menjadi "accepted" | Mengupdate *field status* di database, respon sukses (200 OK) | 200 OK | **Valid** |

### 4.3.2 Pengujian Keamanan Autorisasi & Middleware (JWT Testing)
Pengujian ini secara khusus membidik ketahanan *Middleware* pelindung *endpoint* dari upaya akses tidak sah (*Unauthorized Access*). Skenario ini diuji pada *endpoint* privat `/api/students`.

1. **Pengujian Tanpa Token (*Missing Token*)**
   * **Skenario**: Menembak *endpoint* privat namun *header* `Authorization` dikosongkan.
   * **Hasil Aktual**: Middleware mendeteksi ketiadaan token dan seketika memotong *request*, memberikan respons `401 Unauthorized (Missing or malformed JWT)`. (Valid).

2. **Pengujian Token Invalid (*Signature Mismatch / Manipulasi*)**
   * **Skenario**: Memasukkan Token JWT, namun merubah (memanipulasi) satu huruf di bagian akhir token untuk mengelabui sistem.
   * **Hasil Aktual**: Metode verifikasi *Signature* gagal karena kunci rahasia berbeda dengan payload. Merespon `401 Unauthorized (Invalid or expired JWT)`. (Valid).

3. **Pengujian Token Kedaluwarsa (*Expired Token*)**
   * **Skenario**: Menggunakan token sah yang didapatkan hari kemarin (melewati batas kedaluwarsa 24 jam).
   * **Hasil Aktual**: Middleware membaca bagian klaim *Exp*, dan menggagalkan otentikasi dengan status `401 Unauthorized`. (Valid).

4. **Pengujian Batas Hak Akses (*Role Based Access Control - RBAC*)**
   * **Skenario**: Token JWT valid milik "Wali Murid" mencoba mengakses *endpoint* khusus Admin (seperti `PUT /students/status` untuk menyetujui kelasnya sendiri).
   * **Hasil Aktual**: Sistem mengizinkan otentikasi JWT, namun terblokir pada *Middleware* pengecekan Role, memberikan respons penolakan tegas `403 Forbidden (Insufficient Role)`. (Valid).

## 4.4 Evaluasi Sistem (Post-Testing)

Setelah seluruh pengujian *Black Box API* dan pengujian keamanan otorisasi dilakukan menggunakan Postman, dilakukan evaluasi teknis terhadap kinerja *Back End* sistem pendaftaran online Bimbel PAUD TK Aqila.

1. **Evaluasi Keandalan Logika (Business Logic) API**
Sistem berhasil menangani seluruh skenario manipulasi data dasar (CRUD). Fungsionalitas pendeteksian duplikasi data (seperti validasi *email* unik) berjalan sempurna, mencegah terjadinya anomali data di tingkat *database*. 

2. **Evaluasi Keamanan Terhadap Akses Ilegal**
Penggunaan JWT (JSON Web Token) dengan lapisan *Role Based Access Control* (RBAC) pada *Middleware* Golang terbukti sangat efektif. Upaya memanipulasi *signature* token atau menggunakan hak akses wali murid untuk menembus *endpoint* admin langsung diinterupsi oleh sistem sebelum *query* ke basis data dijalankan. Hal ini memastikan bahwa data pendaftaran sangat aman dari potensi peretasan dan kebocoran.

3. **Tindak Lanjut Perbaikan (Agile Adaptation)**
Selama pengujian, ditemukan bahwa pesan *error* bawaan sistem GORM dan GoFiber terkadang terlalu teknis (*verbose*). Pada iterasi *Sprint* terakhir, *error handling* telah dibungkus ulang (di-*refactor*) menjadi format JSON balasan yang lebih ramah dan terstruktur (contoh: `{"status": "error", "message": "Email sudah digunakan"}`) sehingga mempermudah sistem *Front End* dalam memproses respons penolakan.

Secara keseluruhan, integrasi berbasis API REST ini memvalidasi lalu lintas *database* tanpa adanya kebocoran memori (*memory leak*) maupun *server crash*, memastikan *Back End* ini sangat stabil dan siap menjadi pondasi kokoh untuk melayani aplikasi *Front End*.
