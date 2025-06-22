<?php
require_once '../../config/session.php';
require_once '../../controllers/categoryController.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

// Ambil kategori pemasukan & pengeluaran
$incomeCategories = getCategoriesByType('income');
$expenseCategories = getCategoriesByType('expense');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kategori | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .badge-type {
        font-size: 0.85em;
        margin-left: 8px;
        vertical-align: middle;
    }
    .badge-income { background: #198754; }
    .badge-expense { background: #dc3545; }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Daftar Kategori</h2>
        <a href="addCategory.php" class="btn btn-primary mb-3"><b>+</b> Tambah Kategori</a>
        
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-danger text-white fw-bold">
                <span class="bi bi-cash-stack"></span> Kategori Pengeluaran
                <span class="badge bg-light text-dark ms-2"><?= count($expenseCategories) ?> Kategori</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th style="width:180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($expenseCategories): ?>
                            <?php foreach ($expenseCategories as $category): ?>
                            <tr>
                                <td>
                                    <span class="bi bi-arrow-down-circle-fill text-danger"></span>
                                    <?= htmlspecialchars($category['name']); ?>
                                    <span class="badge bg-danger badge-type">Pengeluaran</span>
                                </td>
                                <td>
                                    <a href="editCategory.php?id=<?= $category['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="deleteCategory.php?id=<?= $category['id']; ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center text-muted">Belum ada kategori pengeluaran.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                <span class="bi bi-cash"></span> Kategori Pemasukan
                <span class="badge bg-light text-dark ms-2"><?= count($incomeCategories) ?> Kategori</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th style="width:180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($incomeCategories): ?>
                            <?php foreach ($incomeCategories as $category): ?>
                            <tr>
                                <td>
                                    <span class="bi bi-arrow-up-circle-fill text-success"></span>
                                    <?= htmlspecialchars($category['name']); ?>
                                    <span class="badge bg-success badge-type">Pemasukan</span>
                                </td>
                                <td>
                                    <a href="editCategory.php?id=<?= $category['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="deleteCategory.php?id=<?= $category['id']; ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus kategori ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center text-muted">Belum ada kategori pemasukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include('../includes/footer.php'); ?>

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
