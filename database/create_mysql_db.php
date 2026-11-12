<?php
$host = env('DB_HOST', '127.0.0.1');
$port = env('DB_PORT', '3306');
$user = env('DB_USERNAME', 'root');
$pass = env('DB_PASSWORD', '');
$db   = env('DB_DATABASE', 'sistem_presensi');

echo "Mengecek koneksi ke MySQL di $host:$port...\n";

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "Database `$db` berhasil disiapkan atau sudah ada!\n";
    exit(0);
} catch (PDOException $e) {
    echo "Peringatan: Tidak dapat terhubung ke MySQL ($host:$port).\n";
    echo "Pesan error: " . $e->getMessage() . "\n";
    echo "Pastikan modul MySQL di XAMPP Control Panel sudah dalam status START (Hijau).\n";
    exit(1);
}

