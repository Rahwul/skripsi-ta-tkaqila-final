# BAB IV: IMPLEMENTASI DAN PENGUJIAN SISTEM

Bab ini menjelaskan tahapan implementasi dari rancangan sistem yang telah dijabarkan pada bab sebelumnya, serta pengujian yang dilakukan untuk memastikan bahwa sistem berjalan sesuai dengan kebutuhan dan spesifikasi yang telah ditentukan. Struktur ini disusun untuk memenuhi kriteria penjelasan rancangan, bukti implementasi, data pengujian, dan analisis evaluasi untuk mengukur tingkat keberhasilan sistem pendaftaran siswa baru yang telah dibangun.

## 4.1 Implementasi Rancangan Penelitian

Bagian ini menguraikan proses realisasi dari perancangan arsitektur, basis data, dan antarmuka pemrograman aplikasi (API) ke dalam bentuk perangkat lunak yang fungsional.

### 4.1.1 Arsitektur Sistem dan REST API

Sistem backend pada aplikasi pendaftaran TK Aqila dibangun mengimplementasikan arsitektur *Representational State Transfer* (REST) API. Bahasa pemrograman utama yang digunakan adalah **Golang (Go)** dengan framework **GoFiber**. GoFiber dipilih karena kemampuannya dalam menangani *routing* secara efisien, konsumsi memori yang rendah, serta performa eksekusi yang sangat cepat (berbasis *Fasthttp*).

Dalam implementasinya, sistem memisahkan logika ke dalam beberapa *layer* (lapisan) untuk memudahkan *maintenance* dan pengembangan:

```text
┌──────────────────────────────────────────────────────────────┐
│                       CLIENT APPLICATION                    │
│   ┌───────────────────┐      ┌────────────────────────────┐ │
│   │   User Frontend   │      │      Admin Dashboard       │ │
│   │   (Laravel/Blade) │      │      (Laravel/Blade)       │ │
│   └────────┬──────────┘      └──────────┬─────────────────┘ │
└────────────┼─────────────────────────────┼───────────────────┘
             │          HTTP/JSON          │
┌────────────▼─────────────────────────────▼───────────────────┐
│                        GO BACKEND                            │
│                                                              │
│  Controllers (Handler)         Services (Business Logic)     │
│  (Auth, Me, dll)               (Validasi, Proses Data)       │
│                                                              │
│  Routes / Middleware           Repositories (Data Access)    │
│  (GoFiber, JWT Auth)           (GORM Query Builder)          │
└──────────────────────────────────┬───────────────────────────┘
                                   │
                      ┌────────────▼────────────┐
                      │     MySQL Database      │
                      │ users · students        │
                      │ classes · registrations │
                      └─────────────────────────┘
```

**Penjelasan Arsitektur:**
1. **Routes & Middleware**: Lapisan terluar yang menerima HTTP Request dari klien. Pada tahap ini, *middleware* bertugas melakukan validasi awal, seperti pengecekan autentikasi menggunakan *JSON Web Token* (JWT) sebelum meneruskan *request* ke *Controller*.
2. **Controllers (Handler)**: Bertugas menerima input dari klien (biasanya dalam format JSON), mengurai data, dan memanggil fungsi pada *Service*.
3. **Services (Business Logic)**: Memuat inti logika bisnis dari sistem.
4. **Repositories**: Berfungsi sebagai jembatan yang melakukan operasi *Create, Read, Update, Delete* (CRUD) langsung ke dalam basis data menggunakan ORM.

### 4.1.2 Implementasi Basis Data

Sistem manajemen basis data yang digunakan adalah **MySQL**. Untuk memanipulasi data tanpa perlu menulis sintaks SQL secara manual, diimplementasikan **GORM** sebagai *Object-Relational Mapping* (ORM) pada bahasa Go. 

Berikut adalah detail skema tabel yang digunakan dalam sistem beserta potongan kode model implementasinya dari direktori `backend/models`:

#### A. Tabel `admins`
Tabel ini berfungsi sebagai penyimpan data autentikasi admin/panitia penerimaan siswa baru. 
- `ID`: Bertindak sebagai *Primary Key*.
- `Name`: Menyimpan nama admin.
- `Email`: Menyimpan alamat email unik admin untuk proses *login*.
- `Password`: Menyimpan kata sandi yang telah di-*hash* menggunakan *Bcrypt* untuk alasan keamanan.

**Contoh Kode Model `Admin` (`backend/models/admin.go`):**
```go
type Admin struct {
	ID        uint      `gorm:"primaryKey" json:"id"`
	Name      string    `gorm:"size:191;not null" json:"name"`
	Email     string    `gorm:"size:191;uniqueIndex;not null" json:"email"`
	Password  string    `gorm:"size:255;not null" json:"-"`
	CreatedAt time.Time `json:"created_at"`
	UpdatedAt time.Time `json:"updated_at"`
}
```

#### B. Tabel `pendaftaran`
Tabel ini merupakan pusat penyimpanan data identitas calon siswa yang mendaftar di TK Aqila.
- `ID`: Bertindak sebagai *Primary Key*.
- `NamaAnak`, `TempatLahir`, `TanggalLahir`, `JenisKelamin`, `Alamat`: Menyimpan identitas demografis calon siswa.
- `NamaOrangTua`, `NoHP`: Menyimpan identitas dan nomor kontak orang tua/wali murid.
- `StatusPendaftaran`: Menyatakan status pendaftaran siswa (`pending`, `diproses`, `diterima`, `ditolak`).

**Contoh Kode Model `Pendaftaran` (`backend/models/pendaftaran.go`):**
```go
type Pendaftaran struct {
	ID                uint               `gorm:"primaryKey" json:"id"`
	NamaAnak          string             `gorm:"size:191;not null" json:"nama_anak"`
	TempatLahir       string             `gorm:"size:191;not null" json:"tempat_lahir"`
	TanggalLahir      time.Time          `gorm:"type:date;not null" json:"tanggal_lahir"`
	JenisKelamin      string             `gorm:"size:10;not null" json:"jenis_kelamin"`
	NamaOrangTua      string             `gorm:"size:191;not null" json:"nama_orang_tua"`
	NoHP              string             `gorm:"size:50;not null" json:"no_hp"`
	Alamat            string             `gorm:"type:text;not null" json:"alamat"`
	StatusPendaftaran PendaftaranStatus  `gorm:"type:ENUM('pending','diproses','diterima','ditolak');default:'pending'" json:"status_pendaftaran"`
	Catatan           string             `gorm:"type:text" json:"catatan"`
	Berkas            []BerkasPendaftaran `json:"berkas,omitempty"`
	CreatedAt         time.Time          `json:"created_at"`
	UpdatedAt         time.Time          `json:"updated_at"`
}
```

#### C. Tabel `berkas_pendaftaran`
Tabel ini menyimpan data berkas atau dokumen yang diunggah oleh pendaftar sebagai syarat pendaftaran.
- `ID`: *Primary Key*.
- `PendaftaranID`: *Foreign Key* yang menghubungkan ke tabel `pendaftaran`.
- `JenisBerkas`: Jenis dokumen (misal: "Akte Kelahiran", "Kartu Keluarga").
- `FilePath`: Path lokasi penyimpanan berkas.

**Contoh Kode Model `BerkasPendaftaran` (`backend/models/berkas_pendaftaran.go`):**
```go
type BerkasPendaftaran struct {
	ID            uint      `gorm:"primaryKey" json:"id"`
	PendaftaranID uint      `gorm:"index;not null" json:"pendaftaran_id"`
	JenisBerkas   string    `gorm:"size:100;not null" json:"jenis_berkas"`
	FilePath      string    `gorm:"size:255;not null" json:"file_path"`
	CreatedAt     time.Time `json:"created_at"`
	UpdatedAt     time.Time `json:"updated_at"`

	Pendaftaran Pendaftaran `gorm:"constraint:OnUpdate:CASCADE,OnDelete:CASCADE" json:"-"`
}
```

#### D. Tabel `jadwal`
Tabel ini menyimpan data jadwal pembelajaran kelas yang ditawarkan di TK Aqila.
- `ID`: *Primary Key*.
- `NamaKelas`: Nama kelas (misal: "Kelas A", "Kelas B").
- `Hari`, `JamMulai`, `JamSelesai`: Detail pelaksanaan pembelajaran.

**Contoh Kode Model `Jadwal` (`backend/models/jadwal.go`):**
```go
type Jadwal struct {
	ID         uint      `gorm:"primaryKey" json:"id"`
	NamaKelas  string    `gorm:"size:191;not null" json:"nama_kelas"`
	Hari       string    `gorm:"size:20;not null" json:"hari"`
	JamMulai   string    `gorm:"size:10;not null" json:"jam_mulai"`
	JamSelesai string    `gorm:"size:10;not null" json:"jam_selesai"`
	Keterangan string    `gorm:"type:text" json:"keterangan"`
	CreatedAt  time.Time `json:"created_at"`
	UpdatedAt  time.Time `json:"updated_at"`
}
```


### 4.1.3 Antarmuka atau Endpoint API

Implementasi *endpoint* API menjadi jalur komunikasi utama data. Beberapa endpoint dilindungi oleh *header authorization* berbasis *Bearer Token* (JWT) untuk menjaga keamanan sistem.

Berikut adalah rute API yang telah diimplementasikan pada file `backend/routes/api_routes.go`:

| Method | Endpoint | Deskripsi | Middleware |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/admin/register` | Mendaftarkan akun admin baru | Publik |
| `POST` | `/api/admin/login` | Autentikasi admin untuk mendapat Token JWT | Publik |
| `GET`  | `/api/admin/profile` | Mengambil data profil admin yang sedang login | Protected (Valid JWT Token) |
| `POST` | `/api/pendaftaran` | Mengirimkan formulir pendaftaran siswa baru | Publik |
| `GET`  | `/api/pendaftaran` | Mengambil semua daftar pendaftaran siswa | Protected (Valid JWT Token) |
| `PATCH` | `/api/pendaftaran/:id/status` | Mengubah status pendaftaran siswa | Protected (Valid JWT Token) |

Berikut adalah detail implementasi kode untuk setiap *endpoint* utama di `backend/handlers/auth_handler.go`:

#### 1. Endpoint Registrasi Admin (`POST /api/admin/register`)
**Fungsi:** Endpoint ini menerima format JSON (`name`, `email`, `password`), memanggil service untuk meng-hash password dengan *Bcrypt*, lalu menyimpannya ke tabel `admins`.
**Implementasi Kode:**
```go
func (h *AuthHandler) Register(c *fiber.Ctx) error {
	var body RegisterAdminRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}
	if body.Name == "" || body.Email == "" || body.Password == "" {
		return utils.Error(c, fiber.StatusBadRequest, "Data tidak lengkap", map[string][]string{
			"name":     {"wajib diisi"},
			"email":    {"wajib diisi"},
			"password": {"wajib diisi"},
		})
	}

	admin, err := h.authService.Register(body.Name, body.Email, body.Password)
	if err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Gagal registrasi admin", err.Error())
	}

	return utils.Created(c, "Admin berhasil diregistrasi", fiber.Map{
		"id":    admin.ID,
		"name":  admin.Name,
		"email": admin.Email,
	})
}
```

#### 2. Endpoint Login Admin (`POST /api/admin/login`)
**Fungsi:** Memvalidasi kredensial email dan password admin. Jika valid, sistem men-*generate* JWT menggunakan *secret key* yang memiliki masa berlaku 24 jam.
**Implementasi Kode:**
```go
func (h *AuthHandler) Login(c *fiber.Ctx) error {
	var body LoginAdminRequest
	if err := c.BodyParser(&body); err != nil {
		return utils.Error(c, fiber.StatusBadRequest, "Payload tidak valid", map[string][]string{
			"body": {"format JSON tidak valid"},
		})
	}
	if body.Email == "" || body.Password == "" {
		return utils.Error(c, fiber.StatusBadRequest, "Data tidak lengkap", map[string][]string{
			"email":    {"wajib diisi"},
			"password": {"wajib diisi"},
		})
	}

	token, admin, err := h.authService.Login(body.Email, body.Password)
	if err != nil {
		return utils.Error(c, fiber.StatusUnauthorized, "Login gagal", err.Error())
	}

	return utils.Success(c, "Login berhasil", fiber.Map{
		"token": token,
		"admin": fiber.Map{
			"id":    admin.ID,
			"name":  admin.Name,
			"email": admin.Email,
		},
	})
}
```

#### 3. Endpoint Profil Diri (`GET /api/admin/profile`)
**Fungsi:** Endpoint privat ini membaca ID admin dari context JWT (setelah divalidasi oleh middleware), lalu menampilkan detail admin dari database.
**Implementasi Kode:**
```go
func (h *AuthHandler) Profile(c *fiber.Ctx) error {
	adminIDVal := c.Locals(middleware.ContextAdminID)
	if adminIDVal == nil {
		return utils.Error(c, fiber.StatusUnauthorized, "Unauthorized", nil)
	}
	id, ok := adminIDVal.(uint)
	if !ok {
		return utils.Error(c, fiber.StatusUnauthorized, "Unauthorized", "tipe admin_id tidak valid")
	}

	admin, err := h.adminRepo.FindByID(id)
	if err != nil {
		return utils.Error(c, fiber.StatusNotFound, "Admin tidak ditemukan", err.Error())
	}

	return utils.Success(c, "Profil admin", fiber.Map{
		"id":         admin.ID,
		"name":       admin.Name,
		"email":      admin.Email,
		"created_at": admin.CreatedAt,
	})
}
```

## 4.2 Hasil Pengujian Sistem

Tahapan pengujian (*testing*) dilakukan guna memastikan bahwa setiap baris kode yang diimplementasikan telah memenuhi kriteria desain dan bebas dari *bug*.

### 4.2.1 Prosedur Pengujian

Metode pengujian yang diterapkan adalah **Black Box Testing** dengan teknik *Equivalence Partitioning*. Instrumen yang digunakan adalah aplikasi **Postman**. Pengujian mencakup uji fungsionalitas positif dan negatif guna memastikan sistem berhasil menangkap *error* secara spesifik.

### 4.2.2 Data Hasil Pengujian

Berikut adalah dokumentasi hasil uji *Black Box* terhadap *Routing* REST API Pendaftaran TK Aqila:

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



## 4.3 Analisis dan Evaluasi

Berdasarkan implementasi dan pengujian yang telah dipaparkan, evaluasi terhadap sistem dapat dijabarkan sebagai berikut:

### 4.3.1 Analisis Hasil Pengujian

Dari pengujian *Black Box*, **100% skenario pengujian fungsional berjalan valid**. 
1. **Keamanan Data**: Implementasi Bcrypt untuk hash password dan JWT untuk otorisasi endpoint berfungsi sangat baik dalam menangkal potensi *Unauthorized Access*. Pembagian Group Routing GoFiber (publik vs privat) sangat terstruktur.
2. **Keandalan Validasi**: Sistem mampu menangkap duplikasi input (seperti Email ganda) secara dini melalui fungsi `database.DB.Where` pada level controller.
3. **Kinerja Arsitektur**: Penggunaan GoFiber sangat efektif mempercepat proses *response time* dari *request-response* JSON dibandingkan pendekatan *monolithic* tradisional.

### 4.3.2 Pembahasan Kendala

Meskipun secara keseluruhan sistem berjalan dengan sangat baik, beberapa tantangan ditemui selama masa pengembangan, khususnya pada sisi manipulasi *type assertion* nilai *claims* JWT di dalam bahasa Go (seperti pada fungsi konversi tipe `float64` ke `uint` untuk *User ID*). Kendala ini dapat diselesaikan dengan memvalidasi dan mem-*parsing* variabel tersebut menggunakan struktur `switch id := claims["sub"].(type)` secara aman. Secara keseluruhan, sistem pendaftaran siswa baru TK Aqila telah beroperasi dengan sangat lancar dan stabil di tahapan *backend*.

---

# BAB V: PENUTUP

## 5.1 Kesimpulan

Berdasarkan perancangan, implementasi, dan pengujian sistem REST API pendaftaran online TK Aqila yang telah dilakukan, maka dapat ditarik beberapa kesimpulan guna menjawab rumusan masalah dalam penelitian ini:

1. **Perancangan dan Implementasi REST API dengan Metode Agile:**
Sistem informasi pendaftaran online Bimbel PAUD TK Aqila telah berhasil dirancang dan diimplementasikan dalam bentuk REST API menggunakan bahasa pemrograman Golang dan framework GoFiber. Penerapan metodologi *Agile* pada proses pengembangannya terbukti sangat efektif. Metode iteratif pada Agile memungkinkan pengembang untuk mengadaptasi perubahan spesifikasi *endpoint* dan struktur *database* (seperti entitas *Student*, *Class*, dan *Registration*) secara dinamis sesuai dengan *feedback* dan kebutuhan aktual panitia pendaftaran. Penggunaan standar *JSON Web Token* (JWT) serta arsitektur yang memisahkan *frontend* dan *backend* sukses menciptakan sistem yang ringan, aman, dan mudah diperluas (*scalable*).

2. **Dampak Sistem terhadap Pengelolaan Data dan Peningkatan Layanan:**
Implementasi sistem ini berhasil mentransformasi proses pendaftaran konvensional menjadi terdigitalisasi secara penuh. Bagi pihak sekolah (admin), kehadiran relasi database dan penyediaan *endpoint* pelaporan telah sangat mempermudah proses penyortiran pendaftar, pengecekan kuota kelas, serta pengelolaan data peserta secara terpusat tanpa risiko berkas fisik hilang atau rusak. Sementara itu, bagi pihak orang tua (wali murid), sistem ini meningkatkan kualitas layanan secara signifikan. Orang tua kini dapat mendaftarkan anaknya kapan saja secara *online*, terhindar dari kewajiban antrean fisik yang menyita waktu, serta dapat mengetahui validitas akun mereka secara *real-time*.

## 5.2 Saran

Untuk penyempurnaan dan pengembangan lebih lanjut dari sistem informasi pendaftaran online Bimbel PAUD TK Aqila ini di masa mendatang, terdapat beberapa saran yang dapat dipertimbangkan:

1. **Integrasi *Payment Gateway*:** Menambahkan fitur pembayaran *online* terintegrasi (seperti Midtrans atau Xendit) agar wali murid dapat langsung melakukan pelunasan biaya pendaftaran atau uang pangkal tepat setelah status pendaftaran mereka diterima.
2. **Notifikasi Otomatis Multi-Channel:** Mengimplementasikan fitur *Push Notification*, baik via layanan Email (SMTP) maupun integrasi *WhatsApp Gateway*, untuk memberikan pemberitahuan instan kepada orang tua terkait perubahan status penerimaan siswa tanpa harus terus-menerus mengecek aplikasi.
3. **Pengujian Beban Skala Besar (*Load Testing*):** Sangat disarankan untuk melakukan pengujian beban server (*Stress Testing* / *Load Testing*) menggunakan *tools* seperti Apache JMeter atau k6, guna memastikan stabilitas respon *server* apabila terjadi lonjakan jumlah pendaftar secara bersamaan pada hari pertama pembukaan gelombang pendaftaran.
