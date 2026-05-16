@echo off
setlocal

set HOST=127.0.0.1
set PORT=3000

set GO_EXE="C:\Program Files\Go\bin\go.exe"

REM Variabel environment: backend Go membaca via os.Getenv, bukan otomatis dari file .env Laravel.
REM Set di sini agar langsung bisa jalan untuk konfigurasi lokal default.
set APP_PORT=%PORT%
set JWT_SECRET=tk_aqila_local_secret_2026_change_for_production
set DB_HOST=127.0.0.1
set DB_PORT=3306
set DB_USERNAME=root
set DB_PASSWORD=
set DB_DATABASE=db_tk_aqila

if not exist %GO_EXE% (
  echo Go executable not found at %GO_EXE%
  echo Please install Go first.
  exit /b 1
)

echo Starting Go API on http://%HOST%:%PORT%

REM Ambil module dulu agar dependencies tersedia.
%GO_EXE% mod download 2>&1

REM Jalankan API.
REM Pakai -mod=mod untuk mengabaikan folder vendor jika tidak sinkron.
%GO_EXE% run -mod=mod .\backend\cmd\api 2>&1

endlocal

