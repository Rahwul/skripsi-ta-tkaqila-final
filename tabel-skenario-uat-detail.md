# Tabel Skenario UAT Detail

Dokumen ini adalah tabel UAT terpisah dan lebih detail untuk sistem pendaftaran online TK Aqila berbasis REST API.

## Ringkasan Ruang Lingkup UAT

- Fokus pengujian: fungsi inti pendaftaran, validasi data, keamanan akses endpoint, dan rekap data.
- Aktor uji: Admin Sekolah, Operator Pendaftaran, dan Validator (Kepala Sekolah/perwakilan mitra).
- Tools uji: Postman (atau sejenis), database pengujian, checklist UAT.

## Kriteria Umum Kelulusan UAT

- Minimal 80% skenario berstatus `Pass`.
- Skenario kritis (`UAT-01`, `UAT-02`, `UAT-07`, `UAT-08`) wajib `Pass`.
- Tidak ada temuan kritis terkait kehilangan data, duplikasi tak terkendali, atau bypass autentikasi.

## Matriks Skenario UAT (Detail)

| Kode | Skenario | Prioritas | Aktor Uji | Prasyarat | Data Uji | Langkah Uji | Hasil yang Diharapkan | Kriteria Pass |
|---|---|---|---|---|---|---|---|---|
| UAT-01 | Input data pendaftaran valid | Tinggi | Admin/Operator | API aktif, token valid, DB test kosong/siap | Nama anak, TTL, alamat, nama orang tua, no. HP valid | 1) Login, ambil token. 2) Hit endpoint tambah pendaftar dengan payload valid. 3) Cek response. 4) Verifikasi data di endpoint list/DB. | API mengembalikan status sukses; data tersimpan; ID pendaftar terbentuk; data muncul di daftar. | Status sukses dan data tersimpan 100% sesuai payload. |
| UAT-02 | Validasi field wajib | Tinggi | Admin/Operator | API aktif, token valid | Payload tanpa field wajib (mis. nama/TTL/no. HP) | 1) Kirim request tambah pendaftar dengan field wajib kosong/hilang. 2) Cek response error. 3) Cek DB tidak berubah. | API menolak request; muncul pesan validasi yang jelas; data tidak tersimpan. | Semua request invalid ditolak dan tidak ada insert data. |
| UAT-03 | Validasi format data | Sedang | Admin/Operator | API aktif, token valid | No. HP non-numerik, tanggal format salah, panjang karakter berlebih | 1) Kirim beberapa payload dengan format salah. 2) Cek response tiap kasus. | API mengembalikan error format pada field terkait; tidak ada data kotor masuk DB. | Minimal 1 pesan validasi spesifik per field invalid. |
| UAT-04 | Cegah duplikasi pendaftar | Tinggi | Admin | API aktif, token valid, data pendaftar awal sudah ada | Payload identitas kunci sama (mis. NIK/No KK/kombinasi aturan sistem) | 1) Tambah data pertama (valid). 2) Tambah ulang data identitas sama. 3) Cek response dan DB. | Request duplikat ditolak/ditandai sesuai aturan; DB tidak membuat duplikasi tak terkendali. | Tidak ada data ganda untuk kunci unik yang ditetapkan. |
| UAT-05 | Ubah data pendaftar | Sedang | Admin | API aktif, token valid, data target tersedia | Perubahan alamat/no. HP/nama orang tua | 1) Ambil ID pendaftar. 2) Hit endpoint update. 3) Cek response. 4) Verifikasi data terbaru. | Data berhasil diperbarui; field berubah sesuai input; field lain tetap konsisten. | Data update sesuai payload tanpa merusak field lain. |
| UAT-06 | Ambil daftar pendaftar | Sedang | Admin/Operator | API aktif, token valid, ada data test | - | 1) Hit endpoint list pendaftar. 2) Cek struktur response. 3) Cocokkan jumlah data dengan DB test. | Daftar tampil lengkap; format JSON konsisten; jumlah data sesuai sumber. | Struktur response valid dan data sesuai minimal 95%. |
| UAT-07 | Filter/pencarian data | Sedang | Admin/Operator | API aktif, token valid, data bervariasi tersedia | Parameter nama, periode, status | 1) Hit endpoint list dengan query/filter. 2) Uji beberapa kombinasi filter. 3) Verifikasi output. | Data hasil filter relevan; data di luar kriteria tidak muncul; performa respons tetap wajar. | Hasil filter sesuai parameter pada semua sampel uji. |
| UAT-08 | Akses endpoint privat dengan token valid | Tinggi | Admin/Operator | Akun aktif, endpoint privat tersedia | Token JWT/session valid | 1) Login. 2) Ambil token. 3) Akses endpoint privat. | Akses diizinkan; data sesuai role/hak akses. | Endpoint privat hanya bisa diakses token valid. |
| UAT-09 | Akses endpoint privat tanpa/invalid token | Tinggi | Penguji | Endpoint privat tersedia | Tanpa token, token acak, token kedaluwarsa | 1) Hit endpoint tanpa token. 2) Hit endpoint dengan token invalid/expired. | API menolak akses dengan status autentikasi/otorisasi gagal; tidak membocorkan data. | Semua request tidak sah ditolak 100%. |
| UAT-10 | Rekap data pendaftar | Sedang | Admin/Kepala Sekolah | API aktif, token valid, data test representatif | Data dari beberapa status/periode | 1) Hit endpoint rekap. 2) Cocokkan total per status/periode dengan data sumber. | Nilai rekap akurat; format output bisa dibaca pengguna non-teknis. | Selisih perhitungan = 0 untuk dataset uji. |
| UAT-11 | Alur end-to-end pendaftaran | Tinggi | Operator + Validator | Semua endpoint utama aktif | Dataset 1 calon siswa lengkap | 1) Tambah data. 2) Validasi data. 3) Update jika perlu. 4) Lihat di list/rekap. | Satu alur proses bisnis berjalan tanpa error kritis dari awal sampai akhir. | Semua tahap alur berhasil tanpa blokir proses. |
| UAT-12 | Konfirmasi penerimaan pengguna | Tinggi | Kepala Sekolah/Perwakilan Mitra | UAT-01 s.d. UAT-11 sudah dijalankan | Rekap hasil UAT + catatan temuan | 1) Presentasi hasil uji. 2) Minta penilaian diterima/perlu revisi. 3) Dokumentasikan keputusan. | Ada keputusan formal penerimaan pengguna dan daftar tindak lanjut bila ada. | Tersedia berita acara/lembar persetujuan UAT. |

## Template Bukti Eksekusi per Skenario

Gunakan format ini untuk setiap skenario agar dokumentasi rapi saat dimasukkan ke laporan:

| Field | Isi |
|---|---|
| Kode Skenario | UAT-XX |
| Tanggal Uji | YYYY-MM-DD |
| Penguji | Nama Penguji |
| Endpoint | Contoh: `POST /api/pendaftaran` |
| Request (ringkas) | Payload utama |
| Response Aktual | Status code + pesan |
| Hasil | Pass/Fail |
| Temuan | Deskripsi bug/ketidaksesuaian |
| Rekomendasi | Tindak lanjut perbaikan |
| Retest | Tanggal dan hasil retest |

## Template Rekap Akhir UAT

| Kode | Hasil | Severity Temuan | Tindak Lanjut | Status Akhir |
|---|---|---|---|---|
| UAT-01 | Pass | - | - | Closed |
| UAT-02 | Fail | Major | Perbaiki validasi input | Open |
| UAT-03 | Pass | - | - | Closed |

