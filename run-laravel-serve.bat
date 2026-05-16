@echo off
setlocal

set HOST=127.0.0.1
set PORT=8000

echo Starting Laravel: http://%HOST%:%PORT%

REM Jalankan laravel. Jangan pakai npm di sini, jadi tidak terkena issue execution policy.
php artisan serve --host %HOST% --port %PORT%

endlocal

