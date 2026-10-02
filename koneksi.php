<?php
$host = "mysql.railway.internal";
$port = "3306";
$user = "root";
$pass = "QtjvGLpjrFzgZwHmEmiSlDOnyWhtDUVw";
$db   = "railway";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<b>Koneksi Database Berhasil ke Railway!</b>";
} catch (PDOException $e) {
    echo "Koneksi Database Gagal: " . $e->getMessage();
}
?>