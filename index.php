<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "koneksi.php";

// Buat tabel users otomatis jika belum ada di database
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role enum('admin','kader') NOT NULL,
    kode_wilayah VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)");

// Masukkan akun default jika tabel kosong
$cek = mysqli_query($conn, "SELECT * FROM users LIMIT 1");
if ($cek && mysqli_num_rows($cek) == 0) {
    mysqli_query($conn, "INSERT INTO users (id, nama, username, password, role, kode_wilayah) VALUES 
    (1, 'Administrator DPPKB', 'admin', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'KAB_TANGERANG'),
    (9, 'Kader Kronjo', '360307_KRONJO', '\$2y\$10\$DTWccYVe6YTZYMqEjsEKoO0.NN.YtlsqE6CGWtTCHXVbGRrv2P8e.', 'kader', 'KRONJO')");
}

$error = "";
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row;
            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: kader_dashboard.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SILINGS DPPKB Kabupaten Tangerang</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #4f46e5; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #374151; }
        input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #4f46e5; border: none; color: white; font-weight: bold; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #4338ca; }
        .error { color: red; text-align: center; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>SILINGS</h2>
        <p style="text-align: center; color: #6b7280; font-size: 13px; margin-top: -15px; margin-bottom: 20px;">Sistem Informasi Lingkup Keluarga Resiko Stunting</p>
        
        <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">Masuk ke Sistem</button>
        </form>
    </div>
</body>
</html>