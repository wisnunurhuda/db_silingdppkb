<?php
$host = getenv('MYSQLHOST') ?: "mysql.railway.internal";
$port = getenv('MYSQLPORT') ?: "3306";
$user = getenv('MYSQLUSER') ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: "QtjvGLpjrFzgZwHmEmiSlDOnyWhtDUVw";
$db   = getenv('MYSQLDATABASE') ?: "railway";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Abaikan error PDO
}

$conn = mysqli_connect($host, $user, $pass, $db, $port);
if (!$conn) {
    die("Koneksi MySQLi Gagal: " . mysqli_connect_error());
}
?>