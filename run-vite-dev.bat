@echo off
setlocal

REM Jalankan Vite dev server tanpa melewati wrapper npm.ps1 (PowerShell execution policy).
REM Pastikan package sudah terinstall (npm install).

set HOST=127.0.0.1
set PORT=5173

echo Starting Vite dev: http://%HOST%:%PORT%

REM Pakai node langsung supaya tidak tergantung npm.cmd/ npm.ps1.
if exist node.exe (
  node.exe node_modules\vite\bin\vite.js --host %HOST% --port %PORT%
) else (
  "C:\Program Files\nodejs\node.exe" node_modules\vite\bin\vite.js --host %HOST% --port %PORT%
)

endlocal

