# Final Perbaikan BAB 1-3 dan Skenario UAT

Dokumen ini adalah versi final tindak lanjut komentar dosen penguji untuk BAB 1-3, sekaligus rancangan UAT yang diminta.

## 1) Final Perbaikan BAB 1

### A. Latar Belakang
- Hilangkan pengulangan kalimat lokasi mitra. Pakai satu kalimat yang ringkas dan jelas.
- Tambahkan penguat urgensi berbasis data/fakta, misalnya:
  - Jumlah pendaftar per periode.
  - Rata-rata waktu proses pendaftaran manual.
  - Jumlah kesalahan input/duplikasi berkas pada proses manual.
- Hubungkan masalah lapangan langsung ke solusi teknis REST API.

Contoh kalimat perbaikan:
`TK Aqila berlokasi di Jl. Korma No. 30, Sinar Sari, Kecamatan Dramaga, Kabupaten Bogor, Jawa Barat 16680. Proses pendaftaran yang masih dilakukan secara manual menimbulkan kendala pada kecepatan layanan, ketepatan data, dan kemudahan monitoring sehingga diperlukan sistem pendaftaran online berbasis REST API.`

### B. Rumusan Masalah (Revisi Final)
Gunakan rumusan yang terukur dan spesifik:
1. Bagaimana merancang REST API sistem pendaftaran online untuk memenuhi kebutuhan proses pendaftaran di TK Aqila?
2. Sejauh mana implementasi REST API dapat meningkatkan efisiensi proses layanan pendaftaran dibandingkan alur manual?
3. Sejauh mana implementasi REST API dapat meningkatkan akurasi dan konsistensi data pendaftar?
4. Bagaimana hasil uji penerimaan pengguna (UAT) terhadap kesesuaian fungsi sistem dengan kebutuhan pihak sekolah?

### C. Tujuan Penelitian (Diselaraskan)
1. Menghasilkan rancangan dan implementasi REST API sistem pendaftaran online di TK Aqila.
2. Mengukur peningkatan efisiensi proses pendaftaran setelah sistem diterapkan.
3. Mengukur peningkatan akurasi dan konsistensi data pendaftaran.
4. Mengevaluasi tingkat penerimaan pengguna melalui UAT.

### D. Batasan Masalah (Dipertegas)
- Sistem berfokus pada proses pendaftaran peserta didik baru.
- Implementasi terbatas pada layanan backend REST API (tanpa pembahasan mendalam aplikasi mobile terpisah).
- Pengujian keamanan dibatasi pada autentikasi dan otorisasi dasar endpoint.
- Sistem tidak membahas integrasi dengan sistem eksternal di luar ruang lingkup TK Aqila.
- Pengujian dilakukan pada periode dan jumlah responden terbatas sesuai ketersediaan mitra.

## 2) Final Perbaikan BAB 2

### A. Penguatan Landasan Teori
Tambahkan subbab teori agar tidak hanya satu paragraf:
- Konsep Sistem Informasi Pendidikan.
- REST API: prinsip stateless, resource, endpoint, method HTTP, status code.
- GoFiber Framework: alasan pemilihan, karakteristik, kelebihan teknis.
- Agile Software Development: nilai, tahapan iteratif, alasan kesesuaian dengan proyek.
- Konsep kualitas perangkat lunak yang relevan dengan pengujian (fungsionalitas, usability, reliability sederhana).

### B. Struktur Penulisan yang Disarankan
1. Profil mitra (tetap dipertahankan).
2. Teori inti per topik (minimal 2-3 paragraf per topik + sitasi).
3. Teknologi/tools (Go, GoFiber, MySQL, Postman, dsb).
4. Penelitian terdahulu (minimal 3 studi) dengan tabel perbandingan:
   - Judul/peneliti/tahun.
   - Metode.
   - Teknologi.
   - Hasil.
   - Gap dengan penelitian saat ini.

### C. Output Final BAB 2
- Setiap subbab teori memiliki sitasi yang konsisten.
- Ada narasi hubungan teori dengan kebutuhan penelitian.
- Ada penegasan posisi penelitian (novelty/gap) dari studi terdahulu.

## 3) Final Perbaikan BAB 3

### A. Metode Pengumpulan Data (Wawancara)
Lengkapi detail agar sesuai masukan dosen:
- Jenis wawancara: semi-terstruktur.
- Media: offline/online (pilih sesuai kondisi nyata dan tulis konsisten).
- Responden: kepala sekolah/admin/operator pendaftaran.
- Instrumen: daftar pertanyaan inti per topik (alur, kendala, kebutuhan data, output laporan).
- Output: ringkasan temuan kebutuhan fungsional/nonfungsional.

### B. Metode Pengujian (Tambahan UAT)
Tambahkan pengujian pengguna selain pengujian teknis endpoint:
- Jenis: User Acceptance Test (UAT).
- Tujuan: memastikan fungsi API sesuai kebutuhan proses bisnis mitra.
- Pelaksana: perwakilan pengguna dari TK Aqila.
- Mekanisme: pengguna memvalidasi skenario uji berbasis alur nyata pendaftaran.

## 4) Skenario UAT (Siap Pakai)

### A. Tujuan UAT
- Memastikan setiap fungsi utama sistem pendaftaran online berjalan sesuai kebutuhan pengguna sekolah.
- Memastikan data yang dihasilkan akurat, lengkap, dan mudah ditelusuri.

### B. Aktor UAT
- Admin sekolah.
- Operator pendaftaran.
- (Opsional) Kepala sekolah sebagai pihak validasi hasil laporan.

### C. Lingkungan Uji
- API berjalan pada server pengujian.
- Database pengujian dengan data dummy.
- Tools: Postman (atau tool serupa), dokumentasi endpoint, lembar checklist UAT.

### D. Kriteria Kelulusan
- Minimal 80% skenario berstatus `Pass`.
- Tidak ada temuan kritis pada fungsi inti (pendaftaran, validasi data, rekap data).
- Temuan minor memiliki catatan perbaikan yang jelas.

### E. Daftar Skenario UAT

1. **UAT-01 - Input data pendaftaran valid**
   - Tujuan: memastikan data calon siswa valid dapat disimpan.
   - Langkah uji:
     1) Kirim request tambah pendaftar dengan data lengkap valid.
     2) Cek response API.
     3) Verifikasi data tersimpan di database.
   - Ekspektasi:
     - Status code sukses.
     - Pesan berhasil.
     - Data tampil pada daftar pendaftar.

2. **UAT-02 - Validasi field wajib**
   - Tujuan: memastikan sistem menolak data tidak lengkap.
   - Langkah uji:
     1) Kirim request tanpa field wajib (mis. nama/TTL/no kontak).
     2) Cek response error.
   - Ekspektasi:
     - Status code validasi gagal.
     - Pesan error menyebut field yang kurang.
     - Data tidak tersimpan.

3. **UAT-03 - Cegah duplikasi data penting**
   - Tujuan: menguji kontrol terhadap data pendaftar ganda.
   - Langkah uji:
     1) Tambah data pendaftar A.
     2) Tambah lagi data dengan identitas kunci sama.
   - Ekspektasi:
     - Sistem memberi peringatan/penolakan duplikasi sesuai aturan.
     - Tidak ada data ganda tak terkendali.

4. **UAT-04 - Ubah data pendaftar**
   - Tujuan: memastikan perubahan data berjalan benar dan terekam.
   - Langkah uji:
     1) Ambil satu data pendaftar.
     2) Lakukan update pada beberapa field.
     3) Verifikasi hasil update.
   - Ekspektasi:
     - Data berhasil diperbarui.
     - Nilai lama tergantikan sesuai input baru.

5. **UAT-05 - Lihat daftar pendaftar**
   - Tujuan: memastikan pengguna dapat melihat data pendaftar secara lengkap.
   - Langkah uji:
     1) Panggil endpoint daftar pendaftar.
     2) Cek kelengkapan atribut data.
   - Ekspektasi:
     - Daftar tampil dengan struktur data konsisten.
     - Data sesuai dengan isi database.

6. **UAT-06 - Filter/pencarian data**
   - Tujuan: memastikan data mudah dicari untuk kebutuhan operasional.
   - Langkah uji:
     1) Cari data berdasarkan nama/periode/status.
     2) Cek hasil pencarian.
   - Ekspektasi:
     - Hasil sesuai kata kunci/filter.
     - Tidak menampilkan data yang tidak relevan.

7. **UAT-07 - Akses endpoint dengan token valid**
   - Tujuan: menguji autentikasi dasar endpoint terlindungi.
   - Langkah uji:
     1) Login untuk mendapatkan token.
     2) Akses endpoint privat dengan token valid.
   - Ekspektasi:
     - Akses diizinkan.
     - Response sesuai hak akses pengguna.

8. **UAT-08 - Akses endpoint tanpa token/invalid token**
   - Tujuan: memastikan endpoint terlindungi tidak bisa diakses sembarang pihak.
   - Langkah uji:
     1) Akses endpoint privat tanpa token.
     2) Akses endpoint privat dengan token tidak valid.
   - Ekspektasi:
     - Sistem menolak akses.
     - Response error autentikasi muncul dengan benar.

9. **UAT-09 - Rekap data untuk kebutuhan sekolah**
   - Tujuan: memastikan data bisa dipakai evaluasi administrasi.
   - Langkah uji:
     1) Ambil data rekap pendaftar (jumlah, status, periode).
     2) Cocokkan dengan data transaksi uji.
   - Ekspektasi:
     - Nilai rekap akurat.
     - Format data dapat dipahami pengguna.

10. **UAT-10 - Konfirmasi penerimaan pengguna**
    - Tujuan: mendapatkan persetujuan bahwa sistem sesuai kebutuhan.
    - Langkah uji:
      1) Tampilkan hasil seluruh skenario ke perwakilan mitra.
      2) Minta penilaian diterima/perlu revisi.
    - Ekspektasi:
      - Ada keputusan akhir penerimaan.
      - Jika revisi, ada daftar perbaikan prioritas.

## 5) Template Tabel Hasil UAT

Gunakan tabel ini pada BAB 4 (hasil pengujian), tetapi metode dan skenario dijelaskan di BAB 3.

| Kode UAT | Skenario | Penguji | Tanggal | Hasil (Pass/Fail) | Catatan |
|---|---|---|---|---|---|
| UAT-01 | Input data pendaftaran valid | Admin | YYYY-MM-DD | Pass | - |
| UAT-02 | Validasi field wajib | Operator | YYYY-MM-DD | Pass/Fail | Isi temuan |
| UAT-03 | Cegah duplikasi data penting | Admin | YYYY-MM-DD | Pass/Fail | Isi temuan |

## 6) Checklist Final Sebelum Revisi Dinyatakan Siap

- Rumusan masalah dan tujuan penelitian sudah 1:1 selaras.
- Batasan masalah sudah tegas (fitur, keamanan, integrasi, periode uji).
- BAB 2 sudah diperkaya teori dan sitasi.
- Wawancara di BAB 3 sudah detail (jenis, media, responden, instrumen).
- Metode UAT, skenario, aktor, dan kriteria kelulusan sudah tertulis jelas.
- Keterkaitan alur BAB 1 -> BAB 2 -> BAB 3 sudah konsisten.

