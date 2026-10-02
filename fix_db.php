<?php
include "koneksi.php";

// Paksa buat tabel users
$query = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role enum('admin','kader') NOT NULL,
    kode_wilayah VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $query)) {
    echo "<h2 style='color:green;'>BERHASIL: Tabel 'users' telah dibuat di Railway!</h2>";

    // Masukkan akun admin & kader default
    mysqli_query($conn, "INSERT IGNORE INTO users (id, nama, username, password, role, kode_wilayah) VALUES 
    (1, 'Administrator DPPKB', 'admin', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'KAB_TANGERANG'),
    (9, 'Kader Kronjo', '360307_KRONJO', '\$2y\$10\$DTWccYVe6YTZYMqEjsEKoO0.NN.YtlsqE6CGWtTCHXVbGRrv2P8e.', 'kader', 'Kronjo')");

    echo "<p>Silakan hapus file ini, lalu buka kembali <a href='index.php'>Halaman Login</a>.</p>";
} else {
    echo "<h2 style='color:red;'>Gagal: " . mysqli_error($conn) . "</h2>";
}
?>