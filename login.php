<?php
// session_start();
// Koneksi ke database
include 'koneksi/db.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi!";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashed_password = md5($password);
            if ($hashed_password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['display_name'] = $user['display_name'];
                $_SESSION['role'] = $user['role'];
                
                // Arahkan berdasarkan role
                if ($user['role'] === 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Modal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #bd2a73; /* Warna utama */
            --primary-hover-color: #df549a; /* Warna utama saat hover */
            --secondary-color: #6c757d; /* Warna sekunder */
            --background-color: #f8f9fa; /* Warna latar belakang */
            --text-color: #212529; /* Warna teks */
            --link-hover-color: #ffcc00; /* Warna link saat hover */
            --card-hover-shadow: rgba(0, 0, 0, 0.2); /* Bayangan saat hover */
        }
        body {
            background: linear-gradient(150deg, #aadfff, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* Soft shadow */
            animation: fadeInUp 0.3s ease-in-out; /* Smooth animation */
            background: #ffffff; /* White background */
        }

        .modal-header {
            background-color: var(--primary-color); /* Primary color background */
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 1rem 1.5rem; /* Padding for header */
            font-family: 'Segoe UI', sans-serif;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-body {
            padding: 2rem 1.5rem; /* Body padding */
        }

        .modal-footer {
            border-top: 1px solid #ddd;
        }

        .modal-footer .btn-secondary {
            background-color: var(--secondary-color);
            border-radius: 50px;
        }

        .modal-body .form-floating input {
            padding-left: 20px; /* Ensure padding is consistent */
            border-radius: 50px; /* Rounded input fields */
            border: 1px solid #ced4da; /* Light border */
            box-shadow: none;
        }

        .modal-body .form-floating input:focus {
            border-color: var(--primary-color); /* Primary color border on focus */
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.4);
        }

        .modal-body .form-floating label {
            font-family: 'Segoe UI', sans-serif;
            font-weight: 600;
        }

        .btn-close {
            border-radius: 50%;
            background-color: #f1f1f1;
        }

        .btn-close:hover {
            background-color: #ddd;
        }

        .btn-primary {
            border-radius: 10px;
            background-color: var(--primary-color); /* Primary button color */
            border: none;
            padding: 12px 0;
            font-weight: 600;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #006c72; /* Darker primary color */
            box-shadow: 0 6px 14px rgba(13, 110, 253, 0.35);
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo Animation */
        @keyframes logoAnimation {
            0% {
                transform: scale(0.8); /* Mulai dari kecil */
                opacity: 0;
            }
            50% {
                transform: scale(1.1); /* Memperbesar sedikit */
                opacity: 1;
            }
            100% {
                transform: scale(1); /* Kembali ke ukuran normal */
                opacity: 1;
            }
        }

        /* Animasi teks untuk judul dan deskripsi */
/* Animasi Bounce untuk teks */
@keyframes bounce {
    0% {
        transform: translateY(0);
    }
    20% {
        transform: translateY(-10px);
    }
    40% {
        transform: translateY(0);
    }
    60% {
        transform: translateY(-5px);
    }
    80% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(0);
    }
}

/* Animasi Fade-In dengan sedikit scale (memperbesar teks saat muncul) */
@keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

/* Apply bounce animation pada h1 */
h1 {
    animation: bounce 1s ease infinite;
    font-family: 'Segoe UI', sans-serif;
}

/* Apply fade-in with scale pada p (deskripsi) */
p {
    animation: fadeInScale 1s ease-out;
    font-family: 'Segoe UI', sans-serif;
    font-weight: 600;
}

/* Efek hover pada h1 */
h1:hover {
    color: var(--primary-color);
    text-decoration: underline;
    transition: all 0.3s ease;
}



        .img-fluid {
            animation: logoAnimation 1s ease-out; /* Durasi 1 detik */
        }

        /* Optional: Tambahkan efek hover pada logo */
        .img-fluid:hover {
            transform: scale(1.05); /* Memberikan efek membesar sedikit saat hover */
            transition: transform 0.3s ease-in-out;
        }

        /* Hero Section */
        .container {
            height: 100dvh;
        }

        .btn-login {
            border-radius: 10px;
            padding: 10px 30px;
            font-weight: 600;
            background-color: var(--primary-color); /* Primary button color */
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: var(--primary-hover-color); /* Hover color */
            color: white;
        }

        h1, p {
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
    
</head>
<body style="background-color: #f8f9fa;">
<!-- Hero / Welcome Section -->
<div class="container d-flex justify-content-center vh-100">
    <div class="text-center">
        <img src="assets/img/logos.png" alt="Logo" class="img-fluid mb-4" style="width: 280px; max-height: 280px;">
        
        <h1 class="text-black mb-3 typing-text p-3">Sistem Pakar Penyakit Jantung</h1>
        <p class="text-black mb-4 typing-text p-3">Selamat datang di sistem pakar kami. Silakan masuk untuk melanjutkan.</p>
        
        <button class="btn btn-login btn-lg px-5" data-bs-toggle="modal" data-bs-target="#loginModal">
            Masuk
        </button>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white">
        <h5 class="modal-title" id="loginModalLabel">Sistem Pakar Penyakit Jantung</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" style="padding-left: 25px;" id="username" name="username" placeholder="Username" required>
                <label for="username" style="padding-left: 25px;">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" style="padding-left: 25px;" id="password" name="password" placeholder="Password" required>
                <label for="password" style="padding-left: 25px;">Password</label>
            </div>
            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
