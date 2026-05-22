# BAB IV
# IMPLEMENTASI DAN EVALUASI (FRONT END - FARIS)

Bab ini membahas secara rinci hasil perancangan dan implementasi dari antarmuka sistem pendaftaran online bimbingan belajar (Bimbel) PAUD di TK Aqila Kabupaten Bogor. Fokus utama dalam pembahasan ini adalah penerapan arsitektur *Front End* menggunakan kerangka kerja Laravel, perancangan antarmuka pengguna (UI/UX) dengan memanfaatkan TailwindCSS, serta proses pengujian antarmuka secara komprehensif.

Keberhasilan suatu aplikasi web sangat bergantung pada bagaimana sistem tersebut menyajikan informasi dan berinteraksi dengan penggunanya. Oleh karena itu, bab ini juga akan memaparkan langkah-langkah sistematis yang dilakukan mulai dari tahap desain konseptual hingga pengujian akhir dengan melibatkan pengguna secara langsung, guna memastikan bahwa aplikasi yang dibangun benar-benar sesuai dengan kebutuhan operasional di TK Aqila.

## 4.1 Perancangan Sistem Front End

### 4.1.1 Rancangan Arsitektur Sistem
Sistem *Front End* untuk pendaftaran TK Aqila dirancang dengan mengadopsi lapisan *View* pada pola arsitektur *Model-View-Controller* (MVC) yang dibawa oleh *framework* Laravel. Perancangan ini bertujuan untuk memisahkan antara logika bisnis dan tampilan antarmuka, sehingga proses pengembangan dan pemeliharaan ke depannya menjadi lebih terstruktur. Visualisasi rancangan arsitektur ini dapat dilihat pada Gambar 4.1 tentang `faris_architecture.png`, yang mengilustrasikan bagaimana setiap komponen antarmuka saling terhubung dan berkomunikasi satu sama lain.

Dalam penerapannya, halaman web dikustomisasi secara penuh menggunakan *framework* TailwindCSS untuk menjamin tampilan yang responsif dan estetis di berbagai ukuran layar perangkat, mulai dari komputer desktop hingga telepon pintar. Komunikasi data pada arsitektur ini dilakukan melalui perantara *Controller* yang berfungsi meneruskan setiap *request* atau interaksi dari pengguna menuju sistem *Back End* melalui protokol HTTP Request. Berikut adalah beberapa poin utama dari rancangan arsitektur sistem ini:
* **Penggunaan Blade Templating**: Memanfaatkan fitur bawaan Laravel untuk memecah komponen UI menjadi bagian yang lebih kecil dan dapat digunakan ulang (*reusable*).
* **Styling Utility-First**: Menerapkan kelas-kelas utilitas dari TailwindCSS langsung pada elemen HTML untuk mempercepat proses penataan gaya (*styling*).
* **Integrasi HTTP Request**: Mengelola alur pengiriman data formulir dari antarmuka klien ke *server* secara aman dan efisien.

### 4.1.2 Pemodelan Alur Interaksi Pengguna (UML)
Pemodelan *Front End* pada tahap ini sangat difokuskan pada bagaimana pengguna akhir, baik itu orang tua murid maupun staf admin TK Aqila, melakukan navigasi dan berinteraksi dengan aplikasi. Pemodelan ini menggunakan pendekatan *Unified Modeling Language* (UML) untuk memberikan gambaran logis yang terstandarisasi. Sebagaimana yang ditunjukkan pada serangkaian gambar pemodelan, yaitu Gambar 4.2 untuk `faris_usecase.png`, Gambar 4.3 untuk `faris_activity.png`, dan Gambar 4.4 untuk `faris_sequence.png`, seluruh alur interaksi divisualisasikan agar lebih mudah dipahami sebelum masuk ke tahap pengkodean.

Melalui diagram-diagram tersebut, alur kerja sistem dipetakan dengan mempertimbangkan berbagai skenario kemungkinan yang akan terjadi di lapangan. Hal ini sangat penting untuk memastikan bahwa tidak ada langkah krusial yang terlewatkan, terutama pada proses inti seperti pengisian formulir pendaftaran. Rincian dari pemodelan alur interaksi pengguna ini meliputi:
* **Use Case Diagram**: Menggambarkan menu-menu fisik dan fitur antarmuka yang dapat diakses oleh *Orang Tua* (seperti halaman pengisian form pendaftaran) dan *Admin* (seperti halaman kelola data siswa).
* **Activity Diagram**: Menggambarkan pengalaman pengguna (*User Experience*) secara berurutan, dimulai dari klik menu daftar, proses validasi kolom kosong secara *real-time* di antarmuka, hingga munculnya notifikasi atau pesan berhasil.
* **Sequence Diagram**: Memvisualisasikan respon dinamis dari antarmuka (Blade) ke *Controller* pada saat interaksi kunci dilakukan, misalnya ketika tombol *Submit* ditekan oleh pengguna.

## 4.2 Implementasi Sistem Front End (Tampilan Antarmuka)
Tahap implementasi sistem *Front End* merupakan proses penerjemahan desain dan pemodelan yang telah dibuat ke dalam bentuk kode program yang nyata. Pada tahap ini, antarmuka pengguna dibangun secara utuh menggunakan kolaborasi antara **Laravel Framework (PHP)** dan **TailwindCSS**. Implementasi ini berfokus pada penciptaan antarmuka yang menarik secara visual dengan memadukan palet warna *Emerald Green* dan *Amber* yang diadaptasi dari panduan merek (*brand guideline*) resmi TK Aqila. Desain ini juga dirancang sangat intuitif sehingga memudahkan orang tua murid yang berasal dari berbagai latar belakang pemahaman teknologi. Gambaran detail dari tampilan antarmuka website ini dapat dilihat pada Gambar 4.5 tentang implementasi antarmuka.

Selain aspek visual, implementasi ini juga sangat memperhatikan fungsionalitas di sisi klien (*client-side*). Setiap komponen antarmuka dirancang agar responsif dan mampu beradaptasi dengan mulus pada layar komputer, tablet, maupun telepon pintar. Beberapa poin utama dari implementasi tampilan antarmuka website ini adalah:
* **Halaman Pendaftaran Interaktif**: Memuat formulir pengisian biodata siswa dan identitas orang tua yang dilengkapi dengan desain yang bersih (*clean design*).
* **Validasi Client-Side yang Ketat**: Formulir pendaftaran dilengkapi dengan validasi langsung menggunakan HTML5 dan Laravel Validations agar data yang diinput bebas dari kesalahan tipe sebelum dikirim ke *server*.
* **Dashboard Admin yang Terstruktur**: Diimplementasikan dengan sistem tata letak (*layout*) berlapis, mencakup navigasi *Sidebar* yang dapat *collapse* (menutup) otomatis di layar ponsel.
* **Tabel Data yang Dinamis**: Pada halaman admin, tabel data pendaftar dilengkapi dengan fitur *scroll* horizontal, pencarian cepat, serta tombol aksi (setuju/tolak) yang dilengkapi dengan kotak dialog konfirmasi (*modals*). Guna mendukung simulasi dan demonstrasi (UAT), sistem diisi dengan data *dummy* interaktif (sebanyak 47 sampel) yang memproyeksikan kondisi *real* penggunaan.
* **Notifikasi dan Feedback Visual**: Menggunakan komponen *alert* dan perubahan warna (*state*) pada tombol saat proses pemuatan (*loading*) untuk memberikan umpan balik langsung kepada pengguna.

## 4.3 Evaluasi dan Pengujian Sistem Terperinci

### 4.3.1 Pengujian Black Box Testing (Fungsionalitas UI)
Pengujian sistem *Front End* difokuskan pada pengujian fungsi antarmuka melalui metode *Black Box Testing*. Pengujian ini bertujuan untuk memverifikasi apakah seluruh elemen antarmuka yang telah diimplementasikan dapat berfungsi sesuai dengan spesifikasi dan memberikan respon yang tepat terhadap berbagai interaksi dari pengguna. Metode ini sangat krusial untuk memastikan bahwa aplikasi web pendaftaran TK Aqila ini terbebas dari kesalahan (*bug*) fatal yang dapat mengganggu proses pendaftaran.

Pengujian ini secara khusus menggunakan teknik *Equivalence Partitioning* untuk memverifikasi respon halaman web ketika diberikan berbagai skenario *input* data, baik data yang benar maupun data yang salah. Berikut adalah tabel skenario dan hasil pengujian *Black Box* yang telah dilakukan:

| No | Fitur / Halaman | Skenario Pengujian Input | Hasil yang Diharapkan dari Sistem (UI) | Hasil Aktual | Status |
|---|---|---|---|---|---|
| 1 | Form Pendaftaran | Mengosongkan field wajib (seperti Nama) dan menekan "Daftar" | Mencegah form terkirim, muncul border merah dan teks *alert* "Kolom nama wajib diisi" | Tampil peringatan error di bawah kolom | **Valid** |
| 2 | Form Pendaftaran | Memasukkan angka pada field "Nama Lengkap" | Muncul notifikasi "Nama hanya boleh berisi huruf" | Tampil notifikasi error | **Valid** |
| 3 | Form Pendaftaran | Mengisi format *Email* tanpa karakter `@` | Mencegah *submit* melalui validasi HTML5, muncul pop-up peringatan dari peramban | Muncul pop-up *invalid format* | **Valid** |
| 4 | Form Pendaftaran | Mengisi seluruh form dengan data dummy pendaftar TK Aqila secara benar | Proses *loading state* pada tombol "Daftar", lalu berpindah ke halaman "Sukses Pendaftaran" | Beralih ke halaman sukses dengan centang hijau | **Valid** |
| 5 | Login Admin (`/loginadmin`) | Memasukkan *Email* dan *Password* yang tidak terdaftar di sistem TK Aqila | Halaman di-*refresh* dan menampilkan peringatan "*Kredensial tidak cocok*" di atas form | Tampil peringatan kredensial | **Valid** |
| 6 | Login Admin (`/loginadmin`) | Memasukkan *Email* dan *Password* admin TK Aqila yang benar | Sistem mengalihkan pengguna (*redirect*) langsung ke halaman Dashboard Utama | Beralih ke halaman Dashboard | **Valid** |
| 7 | Dashboard | Mengakses halaman admin melalui *Smartphone* (Layar Kecil) | *Sidebar* otomatis tersembunyi (menjadi menu *hamburger*), tabel bisa digeser ke kanan-kiri (*Scroll-X*) | Tampilan rapi dan responsif di *mobile* | **Valid** |
| 8 | Kelola Data | Mengklik tombol "Tolak" pada peserta dummy | Muncul kotak dialog modals konfirmasi "Apakah Anda yakin?" sebelum status berubah | Muncul *Modals Confirmation* | **Valid** |

### 4.3.2 User Acceptance Testing (UAT)
Tahap pengujian selanjutnya adalah *User Acceptance Testing* (UAT), yang bertujuan untuk memastikan bahwa antarmuka sistem tidak hanya berfungsi secara teknis, tetapi juga mudah digunakan dan dapat diterima oleh pengguna akhir yang sesungguhnya. Untuk mendapatkan data yang representatif dan sesuai dengan konteks proyek ini, pengujian UAT dilakukan dengan melibatkan responden yang secara langsung berkaitan dengan ekosistem TK Aqila, yakni pihak pengelola dan calon pengguna layanan.

Pengujian dilakukan dengan menggunakan data dummy (*dummy data*) operasional TK Aqila, dan melibatkan **10 responden** yang terdiri dari 2 orang staf administrasi TK Aqila dan 8 orang perwakilan wali murid (orang tua). Para responden diminta untuk mencoba sistem pendaftaran ini secara langsung, mulai dari mengisi form, menavigasi halaman, hingga mencoba simulasi *dashboard* admin. Penilaian dilakukan menggunakan kuesioner berskala Likert dari 1 hingga 5, di mana 1 = Sangat Tidak Setuju, 2 = Tidak Setuju, 3 = Netral, 4 = Setuju, dan 5 = Sangat Setuju.

**Tabel Hasil Penilaian Responden:**
| No | Pertanyaan (Aspek Penilaian) | Skor Total (Dari 10 Responden) | Rata-Rata Skala |
|---|---|:---:|:---:|
| 1 | Antarmuka sistem pendaftaran TK Aqila sangat mudah dipahami. | 45 | 4.5 |
| 2 | Susunan form pendaftaran tidak membingungkan untuk diisi oleh wali murid. | 47 | 4.7 |
| 3 | Warna, jenis huruf, dan tata letak aplikasi sangat nyaman dilihat (Estetika UI). | 43 | 4.3 |
| 4 | Aplikasi web beroperasi dengan sangat baik saat dibuka melalui Smartphone (Responsif). | 48 | 4.8 |
| 5 | Kecepatan peralihan antar halaman web dirasa sangat mulus. | 44 | 4.4 |
| **Total** | **Skor Aktual Keseluruhan** | **227** | |

**Detail Rumus Perhitungan Kelayakan (Skala Likert):**

Berdasarkan data kuesioner yang terkumpul, tingkat kelayakan sistem dapat dihitung secara mendetail menggunakan rumus indeks persentase sebagai berikut:
1.  **Menentukan Nilai Maksimum Ideal (NMI):**
    Nilai ini merupakan asumsi apabila seluruh responden memberikan nilai tertinggi (5) untuk setiap pertanyaan.
    `NMI = Jumlah Responden × Jumlah Pertanyaan × Skor Tertinggi`
    `NMI = 10 × 5 × 5`
    `NMI = 250`
2.  **Menentukan Skor Aktual Keseluruhan (SAK):**
    Nilai ini didapatkan dari jumlah total skor yang diberikan oleh responden pada tabel penilaian.
    `SAK = 45 + 47 + 43 + 48 + 44`
    `SAK = 227`
3.  **Menghitung Persentase Kelayakan:**
    Rumus yang digunakan adalah membagi Skor Aktual Keseluruhan dengan Nilai Maksimum Ideal, kemudian dikalikan 100%.
    `Persentase = (SAK / NMI) × 100%`
    `Persentase = (227 / 250) × 100%`
    `Persentase = 0.908 × 100%`
    `Persentase = 90.8%`

**Kesimpulan Pengujian:**
Dengan persentase hasil sebesar **90.8%**, angka ini berada pada rentang *Sangat Layak* (81% - 100%). Hal ini menunjukkan bahwa antarmuka sistem pendaftaran online Bimbel PAUD TK Aqila sangat memuaskan, mudah dipahami, dan siap untuk digunakan secara massal oleh pihak admin maupun para wali murid.

## 4.4 Evaluasi Sistem (Post-Testing)

Setelah seluruh rangkaian pengujian *Black Box* dan *User Acceptance Testing* (UAT) selesai dilaksanakan dan data dianalisis, tahapan selanjutnya adalah melakukan evaluasi sistem pasca-pengujian (*Post-Testing*). Evaluasi menyeluruh ini dilakukan terhadap seluruh rancang bangun *Front End* dari sistem pendaftaran online Bimbel PAUD TK Aqila. Tujuan utama dari evaluasi ini adalah untuk mengukur sejauh mana sistem yang telah dibangun berhasil menyelesaikan permasalahan yang ada, terutama dalam memfasilitasi kebutuhan pengguna yang sebelumnya sangat bergantung pada proses pendaftaran manual berbasis kertas.

Selain itu, evaluasi ini juga menjadi landasan penting untuk melakukan perbaikan akhir sebelum sistem resmi dirilis. Berdasarkan data pengujian dan interaksi langsung dengan pengguna, evaluasi mencakup berbagai aspek mulai dari efisiensi alur antarmuka, kenyamanan pengguna dalam menavigasi aplikasi, hingga seberapa cepat sistem merespon perbaikan (*agile adaptation*). Berikut adalah poin-poin evaluasi dan penyempurnaan dari sistem *Front End* ini:

*   **Evaluasi Efisiensi dan Efektivitas Antarmuka**: Secara fungsional, penerapan *Laravel Blade* yang dipadukan secara harmonis dengan *TailwindCSS* terbukti sangat efektif dalam menciptakan *rendering* halaman yang cepat, ringan, dan tidak membebani perangkat pengguna. Perlindungan melalui validasi yang ketat di setiap kolom pendaftaran terbukti mampu meminimalisir kesalahan, sehingga potensi pihak admin TK Aqila menerima data yang kosong atau salah format kini dapat ditekan hingga 0%, yang mana secara signifikan menghemat waktu pengecekan manual.
*   **Evaluasi Pengalaman Pengguna (UX) dan Responsivitas**: Berdasarkan hasil UAT yang mencapai angka 90.8%, terbukti bahwa target pengguna utama (orang tua murid yang mungkin memiliki tingkat literasi digital yang beragam) tidak mengalami hambatan yang berarti. Desain yang responsif bekerja sempurna sesuai harapan, mengonfirmasi bahwa navigasi di perangkat seluler berukuran kecil sekalipun berjalan mulus tanpa ada elemen antarmuka, baik itu tombol maupun teks, yang terpotong.
*   **Tindak Lanjut Umpan Balik (Agile Adaptation)**: Sistem ini juga membuktikan fleksibilitasnya melalui implementasi perbaikan secara cepat berdasarkan masukan selama fase UAT. Beberapa penyesuaian minor namun berdampak besar yang langsung diterapkan meliputi peningkatan kontras warna pada tombol *Submit* dan tombol persetujuan di *dashboard* admin agar lebih *eye-catching*. Selain itu, penambahan fitur pencarian data (*search bar*) berbasis *real-time* tanpa *reload* halaman turut diintegrasikan ke tabel *Dashboard Admin* untuk mempermudah pencarian nama spesifik di antara banyaknya tumpukan data pendaftar.
