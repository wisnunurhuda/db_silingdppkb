<?php
$host = "mysql.railway.internal";
$port = "3306";
$user = "root";
$pass = "QtjvGLpjrFzgZwHmEmISlDOnyWhtDUVw";
$db   = "railway";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Diamkan atau catat error PDO jika perlu
}

$conn = mysqli_connect($host, $user, $pass, $db, $port);
if (!$conn) {
    die("Koneksi MySQLi Gagal: " . mysqli_connect_error());
}
?>