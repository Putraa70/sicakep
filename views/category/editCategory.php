<?php
// editCategory.php - Halaman untuk mengedit kategori

require_once '../../config/session.php';
require_once '../../controllers/categoryController.php';  // Memanggil controller kategori

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php'); // Jika belum login, arahkan ke halaman login
    exit;
}

$categoryId = $_GET['id']; // Mendapatkan ID kategori dari URL
$category = getCategoryById($categoryId); // Memanggil fungsi getCategoryById dari controller

// Jika data kategori tidak ditemukan, arahkan ke halaman list
if (!$category) {
    header('Location: listCategory.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    // Mengupdate kategori
    if (updateCategory($categoryId, $name)) {
        header('Location: listCategory.php'); // Redirect ke halaman list kategori setelah berhasil mengedit
        exit;
    } else {
        $error = 'Gagal mengedit kategori. Coba lagi.';
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
    <style>
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #0062E6;
            border: none;
            color: white;
        }
        .btn-custom:hover {
            background-color: #004BB5;
        }
    </style>
</head>
<body>

<?php include('../includes/header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center">Edit Kategori</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    <?php endif; ?>
    
    <div class="card card-custom p-4">
        <form method="POST" action="editCategory.php?id=<?= $category['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $category['name']; ?>" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Update Kategori</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
