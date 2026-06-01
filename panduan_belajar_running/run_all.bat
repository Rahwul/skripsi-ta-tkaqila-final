@echo off
echo ===================================================
echo     MEMULAI SEMUA SERVICE TK AQILA (LOCAL)
echo ===================================================

REM Berpindah ke folder root (induk) tempat script servis berada
cd /d "%~dp0.."

echo [1/3] Menjalankan Go Backend API di window baru...
start "Go API Backend" cmd /c "run-go-api.bat"

echo [2/3] Menjalankan Laravel Frontend di window baru...
start "Laravel Serve" cmd /c "run-laravel-serve.bat"

echo [3/3] Menjalankan Vite Dev Server di window baru...
start "Vite Dev Server" cmd /c "run-vite-dev.bat"

echo ===================================================
echo   Semua service sedang berjalan di window terpisah!
echo   - Go API: http://127.0.0.1:3000
echo   - Laravel: http://127.0.0.1:8000
echo ===================================================
pause
