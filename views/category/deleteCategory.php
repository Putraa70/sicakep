<?php
// deleteCategory.php - Halaman untuk menghapus kategori

require_once '../../config/session.php';
require_once '../../controllers/categoryController.php';

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: listCategory.php');
    exit;
}

$categoryId = $_GET['id'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (deleteCategory($categoryId)) {
        header('Location: listCategory.php');
        exit;
    } else {
        $error = 'Gagal menghapus kategori. Silakan coba lagi.';
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Kategori | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center">Hapus Kategori</h2>
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php else: ?>
        <p>Apakah Anda yakin ingin menghapus kategori ini?</p>
        <form method="POST" action="deleteCategory.php?id=<?= htmlspecialchars($categoryId); ?>">
            <button type="submit" class="btn btn-danger">Hapus</button>
            <a href="listCategory.php" class="btn btn-secondary">Batal</a>
        </form>
        <?php endif; ?>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>