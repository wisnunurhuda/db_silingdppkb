<?php
// Mengambil kredensial langsung dari Environment Variables Railway
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');

// Jika variabel Railway kosong (misal diakses lokal), gunakan fallback
if (!$host) {
    $host = "mysql.railway.internal"; // atau localhost jika sedang testing lokal
    $port = "3306";
    $user = "root";
    $pass = "QtjvGLpjrFzgZwHmEmISlDOnyWhtDUVw"; // Ganti password lokal Anda jika perlu
    $db   = "railway";
}

// Koneksi PDO
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Tangani error PDO jika ada
}

// Koneksi MySQLi
$conn = mysqli_connect($host, $user, $pass, $db, $port);
if (!$conn) {
    die("Koneksi MySQLi Gagal: " . mysqli_connect_error());
}
?>