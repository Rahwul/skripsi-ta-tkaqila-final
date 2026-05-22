## Login Admin (Lokal)

### URL

- Halaman login admin (frontend Laravel): `http://127.0.0.1:8000/login`

### Kredensial

Lihat: `ADMIN_CREDENTIALS.md`

### Proses singkat

1. Pastikan backend Go API sudah jalan di `http://127.0.0.1:3000`
2. Buka `http://127.0.0.1:8000/login`
3. Isi email & password admin
4. Setelah sukses, data JWT akan disimpan di session Laravel

### Jika backend belum jalan

Kalau tombol login tidak berhasil atau halaman menunggu lama, pastikan sudah menjalankan `run-go-api.bat` (port `3000` harus `LISTENING`).

