@echo off
title Sistem Presensi Magang Bappeda DKI Jakarta
cd /d "%~dp0"
echo ========================================================
echo  SISTEM PRESENSI MAGANG - BAPPEDA PROVINSI DKI JAKARTA
echo  Theme: Civic Horizon
echo ========================================================
echo.
echo Membersihkan cache konfigurasi & rute...
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo.
echo Membuka server Laravel Presensi...
echo URL Sistem Presensi: http://127.0.0.1:8000
echo Akun Login Admin   : admin@presensi.com
echo Password           : password123
echo.
echo (Tekan Ctrl + C untuk keluar)
echo ========================================================
echo.
php artisan serve
pause

