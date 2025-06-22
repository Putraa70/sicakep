<?php
// editCategory.php - Halaman untuk mengedit kategori

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
$category = Category::getCategoryById($categoryId);

if (!$category) {
    header('Location: listCategory.php?msg=' . urlencode('Kategori tidak ditemukan.') . '&status=gagal');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $type = $_POST['type'] ?? '';
    if ($name === '') {
        $error = 'Nama kategori tidak boleh kosong.';
    } elseif ($type !== 'income' && $type !== 'expense') {
        $error = 'Pilih tipe kategori.';
    } else {
        // Pastikan updateCategory() di controller & model menerima $type
        $result = updateCategory($categoryId, $name, $type);
        if ($result === true) {
            header('Location: listCategory.php?msg=' . urlencode('Kategori berhasil diperbarui.') . '&status=sukses');
            exit;
        } elseif (is_array($result)) {
            if ($result['success']) {
                header('Location: listCategory.php?msg=' . urlencode($result['message']) . '&status=sukses');
                exit;
            } else {
                $error = $result['message'];
            }
        } else {
            $error = 'Gagal memperbarui kategori. Silakan coba lagi.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container mt-5">
        <h2 class="text-center">Edit Kategori</h2>
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="editCategory.php?id=<?= htmlspecialchars($categoryId); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?= htmlspecialchars($category['name']); ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Tipe Kategori</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="income"
                           value="income" <?= $category['type'] === 'income' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="income">Pemasukan</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type" id="expense"
                           value="expense" <?= $category['type'] === 'expense' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="expense">Pengeluaran</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="listCategory.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <?php include('../includes/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
