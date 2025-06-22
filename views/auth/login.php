<?php
// login.php - Halaman login pengguna

require_once '../../config/session.php';

if (isLoggedIn()) {
    header('Location: ../dashboard.php'); // Pengguna yang sudah login akan diarahkan ke dashboard
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi dan login pengguna
    require_once '../../controllers/authController.php';
    if (loginUser($email, $password)) {
        header('Location: ../dashboard.php'); // Redirect ke dashboard setelah login
        exit;
    } else {
        $error = 'Email atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sicakep</title>
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0062E6, #33AEFF);
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
            background-color: #0062E6;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0052CC;
        }
    </style>
</head>
<body>

<div class="card p-4" style="width: 100%; max-width: 400px;">
    <h2 class="text-center mb-4">Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <div class="mt-3 text-center">
        <p>Belum punya akun? <a href="register.php" class="text-primary">Daftar di sini</a></p>
    </div>
</div>

<!-- Link ke JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
