## Admin Credentials (Local)

File ini berisi contoh kredensial admin untuk login ke panel admin.

### Default (yang bisa dipakai langsung)

- Email: `admin_test_1@example.com`
- Password: `admin12345`

### Kalau login gagal (admin belum ada)

Login admin di aplikasi ini memakai backend Go dan **tidak membuat admin default otomatis**.
Kalau admin belum tersimpan di database Anda, buat dulu via endpoint:

#### Buat admin (curl) - PowerShell/CMD style

```powershell
$body='{"name":"Admin Test","email":"admin_test_1@example.com","password":"admin12345"}'
Invoke-WebRequest -Uri "http://127.0.0.1:3000/api/auth/register" -Method Post -ContentType "application/json" -Body $body
```

### Setelah admin dibuat

1. Buka: `http://127.0.0.1:8000/login`
2. Masukkan:
   - Email: `admin_test_1@example.com`
   - Password: `admin12345`

