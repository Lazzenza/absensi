@echo off
title Sambungkan Presensi ke MySQL XAMPP
cd /d "%~dp0"
echo ========================================================
echo  SAMBUNGKAN KE MYSQL XAMPP (sistem_presensi)
echo ========================================================
echo.
echo PENTING:
echo Pastikan modul Apache dan MySQL di XAMPP Control Panel sudah dalam status START (warna hijau).
echo.
pause
echo [1/3] Mengonfigurasi file .env untuk koneksi MySQL...
powershell -Command "$c = Get-Content .env; $c = $c -replace '^DB_CONNECTION=.*', 'DB_CONNECTION=mysql'; $c = $c -replace '^# DB_HOST=127.0.0.1', 'DB_HOST=127.0.0.1'; $c = $c -replace '^# DB_PORT=3306', 'DB_PORT=3306'; $c = $c -replace '^# DB_DATABASE=sistem_presensi', 'DB_DATABASE=sistem_presensi'; $c = $c -replace '^# DB_USERNAME=root', 'DB_USERNAME=root'; $c = $c -replace '^# DB_PASSWORD=', 'DB_PASSWORD='; Set-Content .env -Value $c"
php artisan config:clear
php artisan cache:clear
echo.
echo [2/3] Menyiapkan database 'sistem_presensi' di MySQL...
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT=>5]); $pdo->exec('CREATE DATABASE IF NOT EXISTS \`sistem_presensi\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;'); echo 'Database sistem_presensi siap!'.PHP_EOL; } catch(Exception $e) { echo 'Error koneksi MySQL: '.$e->getMessage().PHP_EOL; exit(1); }"
if %ERRORLEVEL% NEQ 0 (
    echo.
    echo [!] GAGAL: MySQL di XAMPP belum aktif atau port 3306 belum siap.
    echo     Silakan buka XAMPP Control Panel, klik tombol START pada MySQL, lalu jalankan file ini kembali.
    echo.
    pause
    exit /b
)
echo.
echo [3/3] Menjalankan migrasi tabel dan seeding data demo...
php artisan migrate:fresh --seed
echo.
echo ========================================================
echo  SUKSES! Sistem Presensi Bappeda DKI siap digunakan di XAMPP!
echo.
echo  Akses Browser:
echo  http://localhost/sistem-presensi/public
echo  atau
echo  http://localhost/sistem-presensi
echo.
echo  Akun Login:
echo  Email    : rachmat.akbar@jakarta.go.id (atau admin@presensi.com)
echo  Password : password123
echo ========================================================
echo.
pause
