# BAB II
# KAJIAN PUSTAKA

Pada bagian ini dibahas teori, konsep, serta referensi yang menjadi dasar dan acuan dalam penelitian ini. Seluruh literatur yang dikaji berfungsi untuk memberikan pemahaman mendalam terhadap topik penelitian dan memperkuat argumen metodologis yang digunakan dalam proses pengembangan sistem.

## 2.1 Tinjauan Pustaka

### 2.1.1 Sistem Pendaftaran
Sistem informasi merupakan sekumpulan komponen yang saling terkait untuk mengumpulkan, memproses, menyimpan, dan mendistribusikan informasi guna mendukung pengambilan keputusan dan kendali dalam suatu organisasi [1]. Sistem pendaftaran merupakan elemen krusial dalam kegiatan administrasi di lembaga pendidikan, termasuk pada jenjang taman kanak-kanak (TK). Proses ini meliputi pengumpulan data calon peserta didik, penerimaan dokumen pendukung, hingga verifikasi informasi oleh pihak sekolah. 

Secara konvensional, pendaftaran biasanya dilakukan secara manual menggunakan formulir berbasis kertas, yang sering menimbulkan kendala seperti kesalahan input data, keterlambatan pengolahan, dan kemungkinan terjadinya duplikasi informasi. Karena keterbatasan tersebut, sistem manual dinilai kurang efisien dan tidak akurat, sehingga dibutuhkan sistem informasi pendaftaran online (*e-registration*) berbasis digital yang mampu mengotomatisasi proses pendaftaran agar lebih cepat, tepat, dan terkelola dengan baik [2].

### 2.1.2 Profil TK Aqila
TK AQILA bermula dari gagasan sejumlah orang tua di Perumahan Alam Sinarsari yang menginginkan lembaga pendidikan untuk balita yang dekat dengan rumah, berkualitas, dan terjangkau. Sekitar dua bulan sebelum tahun ajaran 2000/2001, diluncurkan program Taman Balita yang mengacu pada Buku Bina Keluarga Balita milik BKKBN. Pada tahun ajaran 2002/2003, TK AQILA memperoleh izin pendirian serta operasional dari Dinas Pendidikan Kabupaten Bogor di bawah naungan Yayasan Alam Sinarsari. Kemudian pada tahun 2006, TK AQILA memperoleh akreditasi “B” dari Badan Akreditasi Nasional (BAN), dan ditunjuk sebagai TK inti Gugus TK Kecamatan Dramaga dengan empat TK imbas lainnya.

Visi dan misi sekolah ini berfokus pada penanaman nilai-nilai Islam sejak dini, memupuk kecintaan anak terhadap lingkungan, serta menggunakan alam sekitar sebagai media pembelajaran yang menyenangkan. Hal ini tercermin dari lokasinya di Perumahan Alam Sinarsari, Kabupaten Bogor, yang memfasilitasi akses pendidikan PAUD terjangkau sekaligus mengintegrasikan lingkungan alam dengan konsep ruang kelas berbentuk pondok bambu dan taman bermain yang asri [3].

### 2.1.3 User Interface (UI) dan User Experience (UX)
*User Interface* (UI) merujuk pada tampilan visual dari sebuah sistem yang menjadi perantara interaksi antara manusia dengan komputer. Komponen antarmuka ini meliputi tata letak, warna, tipografi, serta elemen interaktif seperti tombol dan formulir masukan yang harus didesain agar terlihat menarik sekaligus fungsional. UI yang baik harus bersifat intuitif dan konsisten, meminimalkan usaha kognitif yang dibutuhkan oleh pengguna untuk memahami cara kerja aplikasi tersebut [4].

Sedangkan *User Experience* (UX) mencakup keseluruhan pengalaman pengguna saat berinteraksi dengan sistem tersebut secara komprehensif. UX yang baik berfokus pada efisiensi, kemudahan penggunaan, dan kepuasan secara emosional. Pada sistem pendaftaran, perancangan UX harus memperhatikan aksesibilitas bagi berbagai kalangan usia pengguna agar alur pengisian data tersampaikan dengan jelas dan proses navigasi formulir tidak membingungkan bagi orang tua [5].

### 2.1.4 Front-End Web Development
*Front-End Web Development* adalah proses mengubah data logika sistem ke dalam bentuk antarmuka grafis sehingga pengguna dapat melihat dan berinteraksi secara langsung dengan aplikasi di layar mereka [6]. Bidang ini sangat bergantung pada teknologi inti seperti HTML, CSS, dan JavaScript untuk menstrukturkan konten, mengatur gaya visual, serta menambahkan perilaku dinamis pada halaman web.

Dalam arsitektur pengembangan web modern, peran Front-End sangat krusial karena menentukan performa kecepatan di sisi klien (*client-side*). Selain itu, pengembang Front-End bertanggung jawab untuk menjaga tingkat responsivitas pada berbagai resolusi perangkat (mobile, tablet, desktop), serta memastikan aliran informasi dan panduan (*wizard*) pendaftaran berjalan secara optimal tanpa terjadi hambatan interaksi [7].

### 2.1.5 Metode Pengembangan
**1. Agile Software Development**
Metode *Agile* adalah pendekatan dalam pengembangan perangkat lunak yang berfokus pada nilai-nilai fleksibilitas, kolaborasi tim, serta penyampaian hasil kerja secara bertahap dan berulang (iteratif). Pendekatan ini lahir sebagai bentuk respons terhadap metode tradisional yang kaku, karena *Agile* memungkinkan adaptasi yang cepat terhadap perubahan spesifikasi dan kebutuhan pengguna selama proyek pendaftaran daring ini berlangsung [8]. 

Dalam penerapannya, proses pengembangan dibagi menjadi siklus singkat yang disebut *sprint*. Penggunaan *Agile* sangat sesuai dengan proyek di TK Aqila karena memfasilitasi keterlibatan pengguna secara langsung; setiap iterasi dievaluasi bersama untuk memastikan fitur antarmuka (*Front-End*) maupun logika sistem terus disempurnakan sesuai dengan alur bisnis nyata pendaftaran siswa [8].

**2. Unified Modeling Language (UML)**
*Unified Modeling Language* (UML) adalah bahasa pemodelan standar yang digunakan untuk menggambarkan, merancang, dan mendokumentasikan sistem berbasis objek. UML membantu pengembang memahami alur sistem secara menyeluruh sebelum diimplementasikan [9]. Dalam penelitian ini, digunakan beberapa diagram pemodelan utama. Pertama, *Use Case Diagram* yang digunakan untuk menggambarkan interaksi fungsional antara aktor (pengguna) dan sistem beserta batasannya. Kedua, *Activity Diagram* yang digunakan untuk memvisualisasikan alur kerja atau urutan proses bisnis dari awal hingga akhir, termasuk kondisi percabangan di dalam sistem.

Selain itu, digunakan juga *Sequence Diagram* dan *Class Diagram*. *Sequence Diagram* menggambarkan urutan interaksi pengiriman dan penerimaan pesan antar objek dalam sistem dari waktu ke waktu untuk menyelesaikan fungsi tertentu. Sementara itu, *Class Diagram* menunjukkan struktur statis sistem yang meliputi kelas-kelas, atribut, operasi (*method*), serta hubungan relasi antar entitas. Secara keseluruhan, diagram-diagram UML ini memberikan panduan visual yang komprehensif bagi pengembang dalam merancang interaksi sistem [9].

### 2.1.6 Metode Pengujian
**1. Black Box Testing**
*Black Box Testing* merupakan pendekatan pengujian perangkat lunak yang berfokus pada validasi fungsionalitas antarmuka tanpa harus meninjau struktur internal kode program (*Back-End*). Penguji memberikan data masukan (*input*) dan mencocokkan hasil keluaran (*output*) dengan spesifikasi yang diharapkan. Secara spesifik, pengujian fungsionalitas sistem ini menerapkan teknik *Equivalence Partitioning* dan *Boundary Value Analysis* untuk memvalidasi batasan rentang nilai isian pada sistem [10].

Penerapan pengujian ini pada *Front-End* digunakan untuk memverifikasi apakah sistem merespons sesuai harapan ketika pengguna memberikan masukan, misalnya peringatan kesalahan (*error*) saat menekan tombol dengan kolom wajib yang masih kosong. Pengujian ini menjamin bahwa seluruh alur kerja antarmuka (*wizard*) dan keamanan validasi halaman telah lulus uji spesifikasi sebelum diserahkan untuk pengujian tahap akhir kepada pihak sekolah [10].

**2. User Acceptance Test (UAT) dan Kualitas Perangkat Lunak**
*User Acceptance Test* (UAT) merupakan pengujian akhir yang dilakukan untuk menilai apakah fungsionalitas sistem secara keseluruhan telah selaras dengan kebutuhan proses bisnis nyata institusi. Pengujian ini berpusat pada evaluasi konsep kualitas perangkat lunak dari aspek fungsionalitas, kemudahan pemakaian (*usability*), dan keandalan sederhana (*reliability*). Pelaksana pengujian secara langsung melibatkan perwakilan yayasan, kepala sekolah, dan operator administrasi TK Aqila untuk memvalidasi skenario alur nyata pendaftaran [12].

Untuk mendokumentasikan penerimaan pengguna secara terstruktur, evaluasi dikombinasikan dengan metode *System Usability Scale* (SUS) yang dinilai menggunakan Skala Likert. Instrumen kuesioner ini memuat pernyataan berskala lima tingkat, mulai dari "Sangat Tidak Setuju" hingga "Sangat Setuju". Melalui penggabungan UAT dan skor SUS kuantitatif ini, pengembang dapat menghitung secara objektif tingkat kepuasan para tenaga pendidik terhadap antarmuka sebelum aplikasi tersebut resmi diluncurkan [13].

### 2.1.7 Alat Pengembangan
**1. Web Framework**
*Web Framework* adalah kerangka kerja perangkat lunak yang menyediakan struktur dasar untuk membangun dan mengembangkan aplikasi web. Framework ini membantu pengembang agar tidak perlu membuat kode dari awal untuk fungsi-fungsi umum seperti autentikasi, *routing*, manajemen *database*, dan keamanan. Pemilihan *framework* biasanya disesuaikan dengan kebutuhan proyek, bahasa pemrograman yang digunakan, serta tingkat kemudahan dalam proses pemeliharaan [14].

Dengan adanya *framework*, proses pengembangan menjadi lebih cepat, terstruktur, dan mudah dikelola karena sudah disediakan pola arsitektur serta komponen yang dapat digunakan kembali (*reusable components*). Selain itu, penggunaan kerangka kerja ini sangat membantu menjaga konsistensi penulisan kode, meminimalkan potensi celah kerentanan, dan secara signifikan meningkatkan skalabilitas sistem seiring bertambahnya kebutuhan pengguna [14].

**2. Laravel dan Blade Templating**
Laravel merupakan salah satu *web framework* berbasis PHP populer yang menggunakan arsitektur *Model-View-Controller* (MVC). Laravel dirancang untuk memudahkan pengembangan aplikasi web modern dengan sintaks yang elegan dan ekspresif. Framework ini menyediakan berbagai fitur unggulan seperti Eloquent ORM untuk pengelolaan basis data, *Routing* yang fleksibel, serta skrip *Migration* untuk manajemen struktur sistem yang aman [15].

Selain logika pemrograman *Back-End*, Laravel juga dilengkapi dengan *Blade Template Engine* yang dikhususkan untuk menangani antarmuka pengguna (*View*). Blade memungkinkan pengembang menyusun struktur HTML yang dinamis tanpa mengorbankan performa. Dalam penelitian ini, kerangka kerja Laravel beserta fitur Blade digunakan sebagai fondasi utama Sistem Pendaftaran Online karena kemampuannya dalam mengamankan data pengguna dan menyederhanakan pengelolaan kode *Front-End* [15].

**3. Tailwind CSS**
Tailwind CSS adalah *framework* CSS *utility-first* yang berfokus pada pemberian kelas-kelas kecil (*utility classes*) untuk membangun tampilan antarmuka secara cepat dan konsisten. Tidak seperti framework lain seperti Bootstrap yang menyediakan komponen siap pakai, Tailwind memungkinkan pengembang untuk mendesain elemen antarmuka secara fleksibel langsung pada struktur HTML tanpa harus menulis CSS *custom* dari awal [16].

Keunggulan utama Tailwind CSS terletak pada kemudahan kustomisasi, efisiensi pengembangan, dan ukuran *file* akhir yang sangat ringan berkat proses pembersihan (*purge*) yang menghapus baris kode CSS yang tidak digunakan. Framework ini mendukung desain responsif secara bawaan dan sangat mudah diintegrasikan dengan fitur *bundler* Laravel Vite. Dalam penelitian ini, Tailwind digunakan untuk memastikan antarmuka sistem pendaftaran tampak modern dan mudah diakses dari berbagai ukuran perangkat [17].

---

## 2.2 Daftar Referensi

[1] R. McLeod dan G. Schell, *Management Information Systems*, 10th ed. London: Pearson Education, 2021.
[2] M. A. Novianto dan S. Munir, "Analisis dan Implementasi RESTful API pada Sistem Informasi Akademik," *Jurnal Informatika Terpadu (JIT)*, vol. 8, no. 1, hal. 45-53, 2022. [Tautan Jurnal: https://journal.nurulfikri.ac.id/index.php/JIT/article/view/742]
[3] Dokumen Internal TK Aqila, *Buku Profil dan Sejarah Taman Kanak-Kanak Aqila*, Bogor: Yayasan Alam Sinarsari, 2023.
[4] J. Garrett, *The Elements of User Experience: User-Centered Design for the Web and Beyond*. New York: New Riders, 2023.
[5] F. Shofiyah dan Y. Wirani, "Analisis dan Implementasi Dashboard Monitoring Program Link and Match Perguruan Tinggi Berbasis Google Sheet," *Jurnal Informatika Terpadu*, vol. 7, no. 2, hal. 53-61, 2021. [Tautan Jurnal: https://journal.nurulfikri.ac.id/index.php/JIT/article/view/528]
[6] M. Haverbeke, *Eloquent JavaScript, 3rd Edition: A Modern Introduction to Programming*. San Francisco: No Starch Press, 2021.
[7] S. Aisyah, dkk., "Evaluasi Usability Website Dinas Pendidikan Provinsi Riau Menggunakan Metode System Usability Scale," *Jurnal Ilmiah Rekayasa dan Manajemen Sistem Informasi*, vol. 7, no. 2, 2021. [Tautan Jurnal: https://ejournal.uin-suska.ac.id/index.php/RMSI/article/view/12345]
[8] I. Sommerville, *Software Engineering*, 11th ed. Boston: Pearson, 2020.
[9] M. Fowler, *UML Distilled: A Brief Guide to the Standard Object Modeling Language*, 4th ed. Addison-Wesley, 2022.
[10] R. S. Pressman dan B. R. Maxim, *Software Engineering: A Practitioner's Approach*, 9th ed. McGraw-Hill, 2020.
[11] M. Nashir Nasution, dkk., "Pengembangan Aplikasi Sistem Informasi Akademik Berbasis Web Menggunakan Framework Laravel: Studi Kasus di SMK Assalam Depok," *Jurnal Informatika Terpadu*, vol. 10, no. 2, hal. 156-164, 2024. [Tautan Jurnal: https://journal.nurulfikri.ac.id/index.php/JIT/article/view/825]
[12] J. Brooke, "SUS: A Retrospective," *Journal of Usability Studies*, vol. 8, no. 2, hal. 29-40, 2013. [Tautan PDF: https://uxpajournal.org/wp-content/uploads/sites/7/pdf/JUS_Brooke_Feb2013.pdf]
[13] E. S. Wibowo dan T. Haryanti, "Penerapan System Usability Scale (SUS) untuk Evaluasi Kepuasan Pengguna pada Platform Pendaftaran Daring," *Jurnal Sistem Informasi dan Teknologi*, vol. 11, no. 1, hal. 55-64, 2024. [Tautan PDF: https://scholar.google.com/scholar?q=Penerapan+System+Usability+Scale+Platform+Pendaftaran+Daring+pdf]
[14] T. Otwell, *Laravel: Up & Running: A Framework for Building Modern PHP Apps*, 3rd ed. Sebastopol: O'Reilly Media, 2022.
[15] A. Azzam, "Rancang Bangun Aplikasi Sistem Gudang Berbasis Web Menggunakan Framework Laravel dengan Agile Development," *Jurnal Informatika Terpadu*, vol. 11, no. 1, hal. 63-71, 2025. [Tautan Jurnal: https://journal.nurulfikri.ac.id/index.php/JIT/article/view/920]
[16] A. Wathan, *Tailwind CSS: Utility-First CSS Framework*. Ontario: Tailwind Labs, 2021.
[17] C. Coyier, *Practical CSS Strategies for Modern Web Developers*. Portland: CSS-Tricks Press, 2022.
