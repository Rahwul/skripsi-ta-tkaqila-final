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
Skenario pengujian menguji keandalan setiap URL *endpoint* dalam memproses format JSON yang benar maupun salah, mencakup 11 skenario pengujian utama (T01 - T11).

| Kode | Endpoint (Route) | Method | Skenario Pengujian (Payload JSON) | Hasil yang Diharapkan (HTTP Status) | Hasil Aktual (Di Postman) | Status |
|---|---|---|---|---|---|---|
| T01 | `/api/admin/register` | POST | Mengirim data nama, email unik, dan password baru | Menyimpan data admin ke DB, status `201 Created` | 201 Created | **Valid** |
| T02 | `/api/admin/login` | POST | Mengirim email dan password yang cocok dengan DB | Sistem men-generate JWT dan mengembalikannya (200 OK) | 200 OK (Token Generated) | **Valid** |
| T03 | `/api/admin/login` | POST | Mengirim password salah atau email tidak terdaftar | Sistem menolak dengan pesan "Login gagal" (401 Unauthorized) | 401 Unauthorized | **Valid** |
| T04 | `/api/pendaftaran` | POST | Mengirim payload pendaftaran calon siswa lengkap | Data pendaftaran berhasil disimpan (201 Created) | 201 Created | **Valid** |
| T05 | `/api/pendaftaran` | POST | Mengosongkan kolom wajib (mis. nama, alamat, no hp) | Request ditolak, muncul pesan error validasi (400 Bad Request) | 400 Bad Request | **Valid** |
| T06 | `/api/pendaftaran/:id/upload-berkas` | POST | Mengunggah dokumen pendukung (form-data: jenis_berkas & file) | Berkas disimpan di server, path dicatat ke DB (201 Created) | 201 Created | **Valid** |
| T07 | `/api/pendaftaran` | GET | Admin request dengan token JWT valid untuk mengambil data | Mengembalikan daftar pendaftar dalam array JSON (200 OK) | 200 OK | **Valid** |
| T08 | `/api/pendaftaran/:id/status` | PATCH | Mengirim payload status pendaftaran baru (mis. "diterima") | Status terupdate di database, respons sukses (200 OK) | 200 OK | **Valid** |
| T09 | `/api/pendaftaran/:id` | DELETE | Menghapus baris data pendaftar berdasarkan ID | Data berhasil dihapus dari database (200 OK) | 200 OK | **Valid** |
| T10 | `/api/laporan` | GET | Mengirim parameter query start_date & end_date | Mengembalikan rekapitulasi data pendaftar per periode (200 OK) | 200 OK | **Valid** |
| T11 | `/api/pendaftaran` | GET | Akses endpoint terproteksi tanpa menyertakan Token JWT | Akses ditolak oleh sistem, mengembalikan status 401 Unauthorized | 401 Unauthorized | **Valid** |

#### Dokumentasi Visual Hasil Pengujian REST API (Postman Screenshots)

Berikut adalah gambar tangkapan layar (screenshots) pengujian ke-11 skenario API menggunakan Postman sebagai bukti empiris sistem berjalan dengan valid:

##### 1. T01 - Registrasi Admin Baru (`POST /api/admin/register`)
- **Registrasi Sukses (201 Created)**:
  ![Registrasi Admin Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_register_success.png)
  *Gambar 4.6: Pengujian API Registrasi Admin Sukses*

- **Registrasi Gagal - Duplikasi Email (400 Bad Request)**:
  ![Registrasi Admin Gagal](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_register_error.png)
  *Gambar 4.7: Pengujian API Registrasi Admin Gagal (Duplikasi Email)*

##### 2. T02 & T03 - Login Admin (`POST /api/admin/login`)
- **Login Sukses (200 OK)**:
  ![Login Admin Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_login_success.png)
  *Gambar 4.8: Pengujian API Login Admin Sukses (Mendapatkan Token JWT)*

- **Login Gagal - Password Salah (401 Unauthorized)**:
  ![Login Admin Gagal](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_login_error.png)
  *Gambar 4.9: Pengujian API Login Admin Gagal (Kredensial Salah)*

##### 3. T04 & T05 - Pendaftaran Siswa Baru (`POST /api/pendaftaran`)
- **Submit Pendaftaran Sukses (201 Created)**:
  ![Submit Pendaftaran Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_pendaftaran_create.png)
  *Gambar 4.10: Pengujian API Kirim Data Pendaftaran Siswa Baru*

- **Validasi Gagal - Kolom Kosong (400 Bad Request)**:
  ![Validasi Gagal](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_pendaftaran_validation_error.png)
  *Gambar 4.11: Pengujian Validasi Input Form Kosong*

##### 4. T06 - Upload Berkas Persyaratan (`POST /api/pendaftaran/:id/upload-berkas`)
- **Upload Berkas Sukses (201 Created)**:
  ![Upload Berkas Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_upload_berkas_success.png)
  *Gambar 4.12: Pengujian API Upload Berkas Pendaftaran*

##### 5. T07 - Lihat Semua Data Pendaftaran (`GET /api/pendaftaran`)
- **Ambil Data Pendaftar Sukses (200 OK)**:
  ![Get All Pendaftaran Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_pendaftaran_get_all.png)
  *Gambar 4.13: Pengujian API Mengambil Semua Data Pendaftaran oleh Admin*

##### 6. T08 - Update Status Pendaftaran (`PATCH /api/pendaftaran/:id/status`)
- **Update Status Sukses (200 OK)**:
  ![Update Status Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_update_status_success.png)
  *Gambar 4.14: Pengujian API Update Status Pendaftaran*

##### 7. T09 - Hapus Data Pendaftaran (`DELETE /api/pendaftaran/:id`)
- **Hapus Data Sukses (200 OK)**:
  ![Hapus Data Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_delete_pendaftaran_success.png)
  *Gambar 4.15: Pengujian API Hapus Data Pendaftaran*

##### 8. T10 - Laporan Rekapitulasi (`GET /api/laporan`)
- **Ambil Laporan Sukses (200 OK)**:
  ![Ambil Laporan Sukses](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_laporan_success.png)
  *Gambar 4.16: Pengujian API Get Laporan Periode*

##### 9. T11 - Proteksi Keamanan JWT (`GET /api/pendaftaran` tanpa token)
- **Akses Ditolak (401 Unauthorized)**:
  ![Akses Ditolak](file:///c:/laragon/www/web-pendaftaran-tkaqila/BAB_IV/diagrams/postman_jwt_unauthorized.png)
  *Gambar 4.17: Pengujian Akses Endpoint Privat Tanpa Token JWT*

### 4.3.2 Pengujian Keamanan Autorisasi & Middleware (JWT Testing)
Pengujian ini secara khusus membidik ketahanan *Middleware* pelindung *endpoint* dari upaya akses tidak sah (*Unauthorized Access*). Skenario ini diuji pada *endpoint* privat `/api/pendaftaran`.

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
   * **Skenario**: Token JWT valid milik "Wali Murid" mencoba mengakses *endpoint* khusus Admin (seperti `PATCH /api/pendaftaran/:id/status` untuk menyetujui pendaftarannya sendiri).
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
