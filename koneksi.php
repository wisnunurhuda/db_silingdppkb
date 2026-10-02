<?php
// Menggunakan variabel lingkungan standar Railway MySQL
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');

// Fallback jika dijalankan secara lokal (opsional)
if (!$host) {
    $host = 'localhost';
    $port = '3306';
    $user = 'root';
    $pass = '';
    $db   = 'nama_database_lokal';
}

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Jika baris ini tampil, berarti koneksi BERHASIL!
    echo "Koneksi Database Berhasil ke Railway!";
} catch (PDOException $e) {
    echo "Koneksi Database Gagal: " . $e->getMessage();
}
?>