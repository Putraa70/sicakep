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
$category = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    if ($name === '') {
        $error = 'Nama kategori tidak boleh kosong.';
    } else {
        if (updateCategory($categoryId, $name)) {
            header('Location: listCategory.php');
            exit;
        } else {
            $error = 'Gagal memperbarui kategori. Silakan coba lagi.';
        }
    }
} else {
    $categories = getCategories();
    foreach ($categories as $cat) {
        if ($cat['id'] == $categoryId) {
            $category = $cat;
            break;
        }
    }
    if (!$category) {
        header('Location: listCategory.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    value="<?= htmlspecialchars($category['name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="listCategory.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>