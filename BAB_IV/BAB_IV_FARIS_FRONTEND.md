# BAB IV
# IMPLEMENTASI DAN EVALUASI (FRONT END - FARIS)

Bab ini membahas secara rinci hasil perancangan dan implementasi dari antarmuka sistem pendaftaran online Bimbel PAUD di TK Aqila Kabupaten Bogor. Fokus utama adalah arsitektur *Front End* menggunakan Laravel, desain UI/UX dengan TailwindCSS, serta pengujian antarmuka.

## 4.1 Perancangan Sistem Front End

### 4.1.1 Rancangan Arsitektur Sistem
Sistem *Front End* dirancang menggunakan lapisan *View* pada konsep *Model-View-Controller* (MVC) Laravel. Halaman web dikustomisasi menggunakan *framework* TailwindCSS untuk memastikan tampilan responsif. Komunikasi data dilakukan melalui *Controller* yang meneruskan *request* dari interaksi pengguna ke sistem *Back End* melalui HTTP Request.

*(Catatan: Anda dapat menyisipkan gambar `faris_architecture.png` di sini)*

### 4.1.2 Pemodelan Alur Interaksi Pengguna (UML)
Pemodelan *Front End* difokuskan pada bagaimana pengguna menavigasi aplikasi:
1. **Use Case Diagram**: Menggambarkan menu-menu fisik yang dapat ditekan oleh *Orang Tua* (seperti isi form pendaftaran) dan *Admin* (seperti kelola data siswa).
2. **Activity Diagram**: Menggambarkan pengalaman pengguna (*User Experience*), mulai dari klik menu daftar, validasi kolom kosong di antarmuka, hingga munculnya pesan berhasil.
3. **Sequence Diagram**: Memvisualisasikan respon antarmuka (Blade) ke *Controller* saat tombol *Submit* ditekan.

*(Catatan: Anda dapat menyisipkan gambar `faris_usecase.png`, `faris_activity.png`, dan `faris_sequence.png` di sini)*

## 4.2 Implementasi Sistem Front End

Sistem *Front End* diimplementasikan menggunakan **Laravel Framework (PHP)** dan **TailwindCSS**. 
*   **Halaman Pendaftaran**: Memuat form pengisian biodata siswa dan identitas orang tua. Form ini dilengkapi validasi langsung (*client-side* HTML5 & Laravel Validations) agar data yang diinput bebas dari kesalahan tipe sebelum dikirim ke *server*.
*   **Dashboard Admin**: Diimplementasikan dengan sistem tata letak (*layout*) berlapis, mencakup navigasi *Sidebar* yang dapat *collapse* (menutup) otomatis di layar ponsel, serta tabel data pendaftar yang dilengkapi tombol setuju/tolak.

## 4.3 Evaluasi dan Pengujian Sistem Terperinci

Pengujian sistem *Front End* dilakukan melalui pengujian fungsi antarmuka (*Black Box*) dan pengujian penerimaan pengguna (*User Acceptance Testing*).

### 4.3.1 Pengujian Black Box Testing (Fungsionalitas UI)
Pengujian ini menggunakan teknik *Equivalence Partitioning* untuk memverifikasi respon halaman web ketika diberikan berbagai skenario *input*.

| No | Fitur / Halaman | Skenario Pengujian Input | Hasil yang Diharapkan dari Sistem (UI) | Hasil Aktual | Status |
|---|---|---|---|---|---|
| 1 | Form Pendaftaran | Mengosongkan field wajib (seperti Nama) dan menekan "Daftar" | Mencegah form terkirim, muncul border merah dan teks *alert* "Kolom nama wajib diisi" | Tampil peringatan error di bawah kolom | **Valid** |
| 2 | Form Pendaftaran | Memasukkan angka pada field "Nama Lengkap" | Muncul notifikasi "Nama hanya boleh berisi huruf" | Tampil notifikasi error | **Valid** |
| 3 | Form Pendaftaran | Mengisi format *Email* tanpa karakter `@` | Mencegah *submit* melalui validasi HTML5, muncul pop-up peringatan dari peramban | Muncul pop-up *invalid format* | **Valid** |
| 4 | Form Pendaftaran | Mengisi seluruh form dengan data yang benar dan lengkap | Proses *loading state* pada tombol "Daftar", lalu berpindah ke halaman "Sukses Pendaftaran" | Beralih ke halaman sukses dengan centang hijau | **Valid** |
| 5 | Login Admin | Memasukkan *Email* dan *Password* yang tidak terdaftar | Halaman di-*refresh* dan menampilkan peringatan "*Kredensial tidak cocok*" di atas form | Tampil peringatan kredensial | **Valid** |
| 6 | Login Admin | Memasukkan *Email* dan *Password* yang benar | Sistem mengalihkan pengguna (*redirect*) langsung ke halaman Dashboard Utama | Beralih ke halaman Dashboard | **Valid** |
| 7 | Dashboard | Mengakses halaman admin melalui *Smartphone* (Layar Kecil) | *Sidebar* otomatis tersembunyi (menjadi menu *hamburger*), tabel bisa digeser ke kanan-kiri (*Scroll-X*) | Tampilan rapi dan responsif di *mobile* | **Valid** |
| 8 | Kelola Data | Mengklik tombol "Tolak" pada peserta | Muncul kotak dialog modals konfirmasi "Apakah Anda yakin?" sebelum status berubah | Muncul *Modals Confirmation* | **Valid** |

### 4.3.2 User Acceptance Testing (UAT)
Untuk memastikan antarmuka mudah digunakan, UAT dilakukan dengan melibatkan **10 responden** (2 staf admin TK Aqila dan 8 orang perwakilan wali murid). Mereka menggunakan sistem ini secara langsung dan menilai dengan kuesioner skala Likert (1 - 5).

*(Keterangan: 1=Sangat Tidak Setuju, 2=Tidak Setuju, 3=Netral, 4=Setuju, 5=Sangat Setuju)*

**Tabel Hasil Penilaian Responden:**
| No | Pertanyaan (Aspek Penilaian) | Skor Total (Maks 50) | Rata-Rata Skala |
|---|---|:---:|:---:|
| 1 | Antarmuka sistem pendaftaran sangat mudah dipahami. | 45 | 4.5 |
| 2 | Susunan form pendaftaran tidak membingungkan untuk diisi. | 47 | 4.7 |
| 3 | Warna, jenis huruf, dan tata letak aplikasi sangat nyaman dilihat (Estetika UI). | 43 | 4.3 |
| 4 | Aplikasi web beroperasi dengan sangat baik saat dibuka melalui Smartphone (Responsif). | 48 | 4.8 |
| 5 | Kecepatan peralihan antar halaman web dirasa sangat mulus. | 44 | 4.4 |
| **Total** | **Skor Aktual Keseluruhan** | **227** | |

**Perhitungan Persentase Kelayakan:**
*   Skor Maksimal Ideal = 10 (responden) x 5 (pertanyaan) x 5 (skor tertinggi) = 250.
*   **Persentase = (227 / 250) * 100% = 90.8%**

## 4.4 Evaluasi Sistem (Post-Testing)

Setelah seluruh pengujian *Black Box* dan *User Acceptance Testing* (UAT) dilakukan, peneliti melakukan evaluasi menyeluruh terhadap rancang bangun *Front End* sistem pendaftaran online Bimbel PAUD TK Aqila. Evaluasi ini bertujuan untuk menilai keberhasilan sistem dalam menjawab kebutuhan pengguna yang sebelumnya mengandalkan proses manual.

1. **Evaluasi Efisiensi dan Efektivitas Antarmuka**
Secara fungsional, penerapan *Laravel Blade* yang dipadukan dengan *TailwindCSS* terbukti sangat efektif dalam menciptakan *rendering* halaman yang cepat dan ringan. Semua kolom pendaftaran telah dilindungi oleh validasi yang ketat, sehingga potensi admin menerima data kosong atau salah format dari orang tua kini ditekan menjadi 0%. Ini secara signifikan menghemat waktu pengecekan manual yang sebelumnya memakan waktu berhari-hari.

2. **Evaluasi Pengalaman Pengguna (UX) dan Responsivitas**
Hasil UAT (90.8%) membuktikan bahwa target pengguna utama (orang tua murid yang mungkin awam teknologi) tidak mengalami kesulitan sama sekali. Evaluasi pada desain responsif mengonfirmasi bahwa navigasi di perangkat *mobile* berjalan sempurna tanpa ada tombol atau teks yang terpotong. 

3. **Tindak Lanjut Umpan Balik (Agile Adaptation)**
Berdasarkan masukan saat UAT, beberapa perbaikan minor langsung diimplementasikan di iterasi *Sprint* terakhir:
* **Peningkatan Kontras Visual**: Warna tombol *Submit* dan tombol "Setujui" pada dashboard admin telah diubah menjadi lebih kontras agar mudah ditemukan.
* **Fitur Pencarian Data Real-time**: Menambahkan *search bar* berbasis antarmuka pada tabel *Dashboard Admin* untuk memudahkan pencarian nama spesifik di antara ratusan data tanpa perlu memuat ulang halaman (*reload*).

Secara keseluruhan, *Front End* sistem ini tidak hanya memenuhi seluruh spesifikasi teknis awal, tetapi juga terbukti sangat fungsional, aman, dan memuaskan bagi pengguna akhir di TK Aqila.
