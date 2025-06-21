<?php
// listCategory.php - Halaman untuk melihat daftar kategori

require_once '../../config/session.php';
require_once '../../controllers/categoryController.php';

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

$categories = getCategories();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center">Daftar Kategori</h2>
        <a href="addCategory.php" class="btn btn-primary mb-3">Tambah Kategori</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['name']); ?></td>
                    <td>
                        <a href="editCategory.php?id=<?= $category['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="deleteCategory.php?id=<?= $category['id']; ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>