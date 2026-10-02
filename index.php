<?php
session_start();
include "koneksi.php";

// Buat tabel users otomatis jika belum ada di Railway
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role enum('admin','kader') NOT NULL,
    kode_wilayah VARCHAR(50) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)");

// Masukkan data akun default jika tabel masih kosong
$cek_user = mysqli_query($conn, "SELECT * FROM users LIMIT 1");
if (mysqli_num_rows($cek_user) == 0) {
    mysqli_query($conn, "INSERT INTO users (id, nama, username, password, role, kode_wilayah) VALUES 
    (1, 'Administrator DPPKB', 'admin', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'KAB_TANGERANG'),
    (9, 'Kader Kronjo', '360307_KRONJO', '\$2y\$10\$DTWccYVe6YTZYMqEjsEKoO0.NN.YtlsqE6CGWtTCHXVbGRrv2P8e.', 'kader', 'Kronjo')");
}

$error = "";
if (isset($_POST['login'])) {
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Ganti bagian verifikasi password lama dengan ini:
if (password_verify($password, $row['password'])) {
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['nama'] = $row['nama'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['kode_wilayah'] = $row['kode_wilayah'];

    if ($row['role'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: kader_dashboard.php");
    }
    exit;
} else {
    $error = "Password salah!";
}
    }
    $error = "Username atau Password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SILING - Sistem Informasi Lingkup Keluarga Resiko Stunting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; }
        .header-top { background: linear-gradient(135deg, #8a2be2, #4b0082); color: white; padding: 15px 30px; }
        .card-login { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); background: white; }
        .btn-custom { background-color: #008b8b; color: white; }
        .btn-custom:hover { background-color: #006666; color: white; }
    </style>
</head>
<body>
    <div class="header-top d-flex align-items-center">
        <h4 class="m-0"><b>Siling</b> Sistem Informasi Lingkup Keluarga Resiko Stunting <br><small style="font-size: 12px;">DPPKB Kabupaten Tangerang</small></h4>
    </div>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5">
            <div class="card card-login p-4">
                <div class="text-center mb-3">
                    <!-- Pastikan file logo.png sudah ada di folder proyek -->
                    <img src="./asset/logo2.png" class="rounded-circle mb-2" width="70" height="70" alt="Logo">
                    <h3 class="fw-bold">SILINGS</h3>
                    <p class="text-muted" style="font-size: 13px;">Sistem Informasi Lingkup Keluarga Resiko Stunting</p>
                </div>
                <?php if($error): ?>
                    <div class="alert alert-danger py-2"><?= $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary" style="font-size: 12px;">USERNAME</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary" style="font-size: 12px;">PASSWORD</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-custom w-100 py-2 fw-bold">Masuk ke Sistem</button>
                </form>
                <div class="mt-4 p-3 bg-light rounded text-center text-muted" style="font-size: 12px;">
                    Hai.. Pejuang Tetap Semangat Ya !!!<br>Kalau Capek Ngopi Dulu!!!
                </div>
            </div>
        </div>
    </div>
</body>
</html>