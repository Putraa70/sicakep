<?php
// register.php - Halaman registrasi pengguna

require_once '../../config/session.php';

if (isLoggedIn()) {
    header('Location: ../dashboard.php'); // Pengguna yang sudah login akan diarahkan ke dashboard
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi dan registrasi pengguna
    require_once '../../controllers/authController.php';
    if (!isEmailTaken($email)) {
        if (register($username, $email, $password)) {
            header('Location: login.php'); // Setelah registrasi sukses, arahkan ke halaman login
            exit;
        } else {
            $error = 'Terjadi kesalahan saat mendaftar, coba lagi.';
        }
    } else {
        $error = 'Email sudah digunakan.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | Sicakep</title>
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #FF7E5F, #feb47b);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #FF7E5F;
            border: none;
        }
        .btn-primary:hover {
            background-color: #FF5C3B;
        }
    </style>
</head>
<body>

<div class="card p-4" style="width: 100%; max-width: 400px;">
    <h2 class="text-center mb-4">Registrasi</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>
    <div class="mt-3 text-center">
        <p>Sudah punya akun? <a href="login.php" class="text-primary">Login di sini</a></p>
    </div>
</div>

<!-- Link ke JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
