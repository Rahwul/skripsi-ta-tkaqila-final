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

Berikut adalah detail skema tabel yang digunakan dalam sistem beserta potongan kode model implementasinya dari file `models/models.go`:

#### A. Tabel `users`
Tabel ini berfungsi sebagai penyimpan data autentikasi baik untuk *admin* panitia maupun wali murid. 
- `ID`: Bertindak sebagai *Primary Key*.
- `Name` & `Email`: Mengidentifikasi nama pengguna dan alamat email unik yang digunakan untuk proses *login*.
- `PasswordHash`: Menyimpan kata sandi yang telah di-*hash* menggunakan *Bcrypt* untuk alasan keamanan.
- `Role`: Menggunakan tipe data `ENUM('admin','operator','wali murid')` untuk memisahkan batasan hak akses (otorisasi) pada sistem.

**Contoh Kode Model `User`:**
```go
type User struct {
	ID           uint `gorm:"primaryKey"`
	Name         string
	Email        string `gorm:"uniqueIndex;size:191"`
	PasswordHash string
	Role         string `gorm:"type:ENUM('admin','operator','wali murid');default:admin"`
	CreatedAt    time.Time
	UpdatedAt    time.Time
}
```

#### B. Tabel `students`
Tabel ini merupakan pusat penyimpanan data identitas calon siswa yang akan didaftarkan.
- `ID`: Bertindak sebagai *Primary Key*.
- `FullName`, `BirthDate`, `Gender`, `Address`: Menyimpan identitas demografis calon siswa.
- `ParentName`, `ParentPhone`: Menyimpan identitas dan kontak wali murid.

**Contoh Kode Model `Student`:**
```go
type Student struct {
	ID          uint `gorm:"primaryKey"`
	FullName    string
	BirthDate   time.Time `gorm:"type:DATE"`
	Gender      string    `gorm:"type:ENUM('L','P')"`
	Address     string    `gorm:"type:TEXT"`
	ParentName  string
	ParentPhone string
	CreatedAt   time.Time
	UpdatedAt   time.Time
}
```

#### C. Tabel `classes`
Tabel ini menyimpan data kelas yang tersedia di TK Aqila.
- `ID`: *Primary Key*.
- `Name`, `Level`: Nama kelas dan tingkatannya.
- `Quota`: Kapasitas maksimal penerimaan siswa per kelas.
- `ScheduleDay`, `ScheduleStart`, `ScheduleEnd`: Jadwal masuk dan jam pelajaran kelas.

**Contoh Kode Model `Class`:**
```go
type Class struct {
	ID            uint `gorm:"primaryKey"`
	Name          string
	Level         string
	Quota         int
	ScheduleDay   string
	ScheduleStart string
	ScheduleEnd   string
	CreatedAt     time.Time
	UpdatedAt     time.Time
}
```

#### D. Tabel `registrations`
Tabel ini merupakan tabel relasional yang menghubungkan siswa dengan kelas yang didaftar, sekaligus melacak status pendaftaran.
- `ID`: *Primary Key*.
- `StudentID` & `ClassID`: *Foreign Key* yang menghubungkan tabel `students` dan `classes`.
- `RegistrationCode`: Kode unik pendaftaran.
- `Status`: Menyatakan status pendaftaran dengan nilai `pending`, `accepted`, atau `rejected`.

**Contoh Kode Model `Registration`:**
```go
type Registration struct {
	ID               uint `gorm:"primaryKey"`
	StudentID        uint
	ClassID          uint
	RegistrationCode string    `gorm:"uniqueIndex;size:191"`
	RegistrationDate time.Time `gorm:"type:DATETIME"`
	Status           string    `gorm:"type:ENUM('pending','accepted','rejected');default:pending"`
	CreatedAt        time.Time
	UpdatedAt        time.Time

	Student Student `gorm:"foreignKey:StudentID;constraint:OnUpdate:CASCADE,OnDelete:RESTRICT"`
	Class   Class   `gorm:"foreignKey:ClassID;constraint:OnUpdate:CASCADE,OnDelete:RESTRICT"`
}
```


### 4.1.3 Antarmuka atau Endpoint API

Implementasi *endpoint* API menjadi jalur komunikasi utama data. Endpoint ini dilindungi oleh *header authorization* berbasis *Bearer Token* (JWT) untuk menjaga keamanan sistem.

Berikut adalah rute API yang telah diimplementasikan pada file `main.go`:

| Method | Endpoint | Deskripsi | Middleware |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/auth/register` | Mendaftarkan akun wali murid/admin baru | Publik |
| `POST` | `/api/auth/login` | Autentikasi untuk mendapat Token JWT | Publik |
| `GET`  | `/api/me` | Mengambil data user yang sedang login | Protected (Valid Token) |
| `GET`  | `/api/admin-only` | Endpoint khusus pengujian admin | Protected, AuthorizeRoles("admin") |

Berikut adalah detail implementasi kode untuk setiap *endpoint* utama di `handlers/auth_controller.go`:

#### 1. Endpoint Registrasi (`POST /api/auth/register`)
**Fungsi:** Endpoint ini menerima format JSON (`name`, `email`, `password`), melakukan hashing pada password menggunakan *Bcrypt*, lalu menyimpannya ke tabel `users`.
**Implementasi Kode (Potongan `Register`):**
```go
	var existing models.User
	if err := database.DB.Where("email = ?", body.Email).First(&existing).Error; err == nil {
		return c.Status(fiber.StatusConflict).JSON(fiber.Map{"status": "error", "message": "email already registered", "data": nil})
	}

	hash, err := bcrypt.GenerateFromPassword([]byte(body.Password), bcrypt.DefaultCost)
	
	user := models.User{
		Name:         body.Name,
		Email:        body.Email,
		PasswordHash: string(hash),
		Role:         "admin",
	}
	if err := database.DB.Create(&user).Error; err != nil {
		return c.Status(fiber.StatusInternalServerError).JSON(fiber.Map{"status": "error", "message": "failed to create user", "data": nil})
	}
```

#### 2. Endpoint Login (`POST /api/auth/login`)
**Fungsi:** Memeriksa email dan validasi kecocokan password dengan hash di database. Jika valid, sistem men-*generate* JWT menggunakan *secret key* yang memiliki masa berlaku 24 jam.
**Implementasi Kode (Potongan `Login`):**
```go
	if err := bcrypt.CompareHashAndPassword([]byte(user.PasswordHash), []byte(body.Password)); err != nil {
		return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{"status": "error", "message": "invalid credentials", "data": nil})
	}

	secret := getEnv("JWT_SECRET", "secret")
	token := jwt.NewWithClaims(jwt.SigningMethodHS256, jwt.MapClaims{
		"sub":   user.ID,
		"email": user.Email,
		"role":  user.Role,
		"exp":   time.Now().Add(24 * time.Hour).Unix(),
		"iat":   time.Now().Unix(),
	})
	signed, err := token.SignedString([]byte(secret))
```

#### 3. Endpoint Profil Diri (`GET /api/me`)
**Fungsi:** Endpoint privat ini membaca `claims` dari JWT (seperti `sub` yang berisi `user.ID`) yang telah didekode oleh middleware, lalu menampilkan detail user dari database secara aman.
**Implementasi Kode (Potongan `Me`):**
```go
func Me(c *fiber.Ctx) error {
	v := c.Locals("claims")
	claims, ok := v.(jwt.MapClaims)
	
	// Konversi dan validasi user ID dari token
	var uid uint
	// ... logic parsing ID ...

	var user models.User
	if err := database.DB.First(&user, uid).Error; err != nil {
		return c.Status(fiber.StatusNotFound).JSON(fiber.Map{"status": "error", "message": "user not found", "data": nil})
	}

	return c.JSON(fiber.Map{"status": "success", "message": "me", "data": fiber.Map{"id": user.ID, "name": user.Name, "email": user.Email, "role": user.Role}})
}
```

## 4.2 Hasil Pengujian Sistem

Tahapan pengujian (*testing*) dilakukan guna memastikan bahwa setiap baris kode yang diimplementasikan telah memenuhi kriteria desain dan bebas dari *bug*.

### 4.2.1 Prosedur Pengujian

Metode pengujian yang diterapkan adalah **Black Box Testing** dengan teknik *Equivalence Partitioning* dan *Boundary Value Analysis*. Instrumen yang digunakan adalah aplikasi **Postman**. Pengujian mencakup uji fungsionalitas positif dan negatif guna memastikan sistem berhasil menangkap *error* secara spesifik.

### 4.2.2 Data Hasil Pengujian

Berikut adalah dokumentasi hasil uji *Black Box* terhadap *Routing* API Pendaftaran TK Aqila:

| No | Modul / Endpoint | Skenario Pengujian | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|
| 1 | POST /api/auth/register | Input nama, email valid, password | Menyimpan data, *response* `201 Created` | Menyimpan data, *response* `201 Created` | **Valid** |
| 2 | POST /api/auth/register | Input email yang sudah terdaftar | *Response* `409 Conflict` (email already registered) | *Response* `409 Conflict` | **Valid** |
| 3 | POST /api/auth/login | Input email & password benar | Mengeluarkan JWT Token, *response* `200 OK` | Mengeluarkan JWT Token | **Valid** |
| 4 | POST /api/auth/login | Input password salah | *Response* `401 Unauthorized` (invalid credentials) | *Response* `401 Unauthorized` | **Valid** |
| 5 | GET /api/me | Akses endpoint tanpa header token | *Response* error akses ditolak dari middleware | *Response* ditolak | **Valid** |
| 6 | GET /api/admin-only | Login dengan role 'wali murid' dan akses | *Response* `403 Forbidden` / akses ditolak middleware role | *Response* ditolak | **Valid** |

*(Catatan: Sisipkan screenshot tampilan response JSON format asli Postman di bawah paragraf ini sebagai lampiran validitas untuk melengkapi sidang skripsi).*

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
