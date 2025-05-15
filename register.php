<?php
session_start();
// Koneksi ke database
include '../koneksi/db.php';

$error = "";
$success = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $display_name = trim($_POST['display_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Validasi input
    if (empty($display_name) || empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Semua field harus diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak cocok!";
    } else {
        // Hash password menggunakan MD5
        $hashed_password = md5($password);

        // Periksa apakah username atau email sudah ada
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username atau email sudah digunakan!";
        } else {
            // Simpan pengguna baru ke database
            $stmt = $conn->prepare("INSERT INTO users (display_name, email, username, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $display_name, $email, $username, $hashed_password);
            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
            } else {
                $error = "Terjadi kesalahan saat registrasi.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #273c75; /* Warna utama */
            --primary-hover-color: #0056b3; /* Warna utama saat hover */
            --secondary-color: #6c757d; /* Warna sekunder */
            --background-color: #f8f9fa; /* Warna latar belakang */
            --text-color: #212529; /* Warna teks */
            --link-hover-color: #ffcc00; /* Warna link saat hover */
        }
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            margin-top: 100px;
        }
    </style>
</head>
<body>
<div class="container register-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="display_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="display_name" name="display_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php">Sudah punya akun? Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>