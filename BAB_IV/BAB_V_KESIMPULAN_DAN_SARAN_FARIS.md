# BAB V
# KESIMPULAN DAN SARAN

Bab ini menguraikan kesimpulan akhir yang ditarik dari hasil analisis, perancangan, pengujian, dan evaluasi sistem yang telah dijabarkan pada bab-bab sebelumnya. Selain itu, bab ini juga menyertakan saran untuk perbaikan dan pengembangan sistem di masa mendatang.

## 5.1 Kesimpulan

Berdasarkan hasil penelitian "Rancang Bangun Front End Pendaftaran Online PAUD pada TK Aqila Kabupaten Bogor Menggunakan Laravel Framework dengan Metode Agile Software Development", maka dapat ditarik beberapa kesimpulan guna menjawab rumusan masalah dalam penelitian ini:

1. **Perancangan Sistem yang Efektif dan Efisien**
Sistem informasi pendaftaran online Bimbel PAUD telah berhasil dirancang dan dibangun secara efektif dan efisien. Pemisahan arsitektur antarmuka (*Front End*) yang dibangun menggunakan Laravel Framework dan TailwindCSS menghasilkan tampilan yang sangat ringan dan berfokus pada *User Experience* (UX). Sistem validasi form yang ketat di sisi antarmuka berhasil menekan angka kesalahan input (*human error*) dari pendaftar menjadi 0%, sehingga mempercepat alur administrasi dan penyortiran data oleh sekolah dibandingkan dengan metode pencatatan manual di buku besar.

2. **Penerapan Metode Agile Software Development**
Penerapan metode *Agile Software Development* terbukti sangat sukses dalam memastikan hasil akhir sistem sesuai dengan ekspektasi dan kebutuhan pengguna. Siklus iteratif (*Sprint*) memungkinkan pengembang untuk beradaptasi dengan cepat. Hal ini dibuktikan melalui hasil pengujian UAT (*User Acceptance Testing*) di mana masukan dari pihak sekolah (seperti penyesuaian kontras warna tombol dan penambahan fitur *search bar* interaktif pada tabel) dapat langsung diakomodasi dan diimplementasikan pada iterasi akhir, menghasilkan tingkat kelayakan sistem yang sangat tinggi yaitu sebesar 90.8%.

3. **Dampak Sistem bagi Sekolah dan Orang Tua**
Sistem *Front End* ini terbukti sangat membantu pihak sekolah (admin) dalam mengelola data peserta secara terpusat melalui *Dashboard Admin* yang responsif. Di sisi lain, sistem ini meningkatkan kualitas layanan secara drastis bagi pihak orang tua murid. Mereka tidak perlu lagi membuang waktu datang ke sekolah hanya untuk mengambil dan mengembalikan formulir kertas; proses pendaftaran kini dapat dilakukan kapan saja secara daring langsung dari perangkat layar *Smartphone* mereka masing-masing dengan antarmuka yang tidak membingungkan.

## 5.2 Saran

Walaupun *Front End* sistem pendaftaran online ini telah dievaluasi dengan baik dan berhasil memenuhi spesifikasi awal, terdapat beberapa saran perbaikan yang diusulkan untuk pengembangan fungsionalitas sistem di masa yang akan datang:

1. **Penyempurnaan Notifikasi Front End (Real-time Alerts)**: Disarankan untuk mengimplementasikan *WebSockets* atau *Pusher* di sisi antarmuka agar orang tua bisa menerima notifikasi *pop-up real-time* langsung di layar *browser* segera setelah status pendaftaran mereka diverifikasi atau disetujui oleh admin, tanpa keharusan memuat ulang (*refresh*) halaman secara manual.
2. **Pengembangan PWA (Progressive Web App)**: Ke depannya, antarmuka web (Laravel Blade) dapat ditingkatkan menjadi *Progressive Web App* (PWA) agar para orang tua dapat menginstal jalan pintas (*shortcut*) sistem pendaftaran ini langsung ke *home screen Smartphone* mereka sehingga memberikan akses yang lebih cepat layaknya aplikasi *native Android*.
3. **Penambahan Fitur Cetak Bukti Pendaftaran (Export PDF)**: Berdasarkan evaluasi kelengkapan fitur dari beberapa responden, disarankan agar antarmuka menambahkan fitur unduh/cetak dokumen (seperti *Export to PDF*) di halaman "Status Pendaftaran", sehingga orang tua dapat mengunduh bukti pendaftaran sah yang memuat kode unik pendaftaran untuk ditunjukkan saat hari pertama anak masuk ke sekolah.
