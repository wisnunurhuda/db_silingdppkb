<?php
// Alternatif membaca koneksi via URL Railway yang otomatis tersedia
$database_url = getenv('DATABASE_PRIVATE_URL') ?: getenv('MYSQL_URL');

if ($database_url) {
    $dbparts = parse_url($database_url);
    $host = $dbparts['host'] ?? '';
    $port = $dbparts['port'] ?? '3306';
    $user = $dbparts['user'] ?? '';
    $pass = $dbparts['pass'] ?? '';
    $db   = ltrim($dbparts['path'] ?? '', '/');
} else {
    // Fallback manual jika variabel URL kosong
    $host = getenv('MYSQLHOST') ?: 'localhost';
    $port = getenv('MYSQLPORT') ?: '3306';
    $user = getenv('MYSQLUSER') ?: 'root';
    $pass = getenv('MYSQLPASSWORD') ?: '';
    $db   = getenv('MYSQLDATABASE') ?: '';
}

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Koneksi Database Berhasil ke Railway!";
} catch (PDOException $e) {
    echo "Koneksi Database Gagal: " . $e->getMessage();
}
?>