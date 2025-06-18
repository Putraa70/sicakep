<?php
// editExpense.php - Halaman untuk mengedit pengeluaran

require_once '../../config/session.php';
require_once '../../controllers/expenseController.php';  // Menyertakan controller expense
require_once '../../controllers/categoryController.php'; // Menyertakan categoryController untuk mendapatkan kategori

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php'); // Jika belum login, arahkan ke halaman login
    exit;
}

$error = '';
$expenseId = $_GET['id'] ?? null;  // Mengambil ID pengeluaran dari URL

if ($expenseId) {
    // Mendapatkan pengeluaran berdasarkan ID
    $expense = getExpense($expenseId); // Pastikan ada fungsi getExpenseById di controller
    $category = getCategoryById($expense['category_id']); // Memanggil fungsi getCategoryById untuk mendapatkan kategori
    $categories = getCategories(); // Memanggil getCategories untuk mendapatkan semua kategori
} else {
    $error = 'Pengeluaran tidak ditemukan';
}

// Jika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryId = $_POST['category_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Mengupdate pengeluaran
    if (updateExpense($expenseId, $categoryId, $amount, $description, $date)) {
        header('Location: listExpense.php');  // Redirect setelah berhasil update
        exit;
    } else {
        $error = 'Gagal memperbarui pengeluaran. Coba lagi.';
    }
}
?>

<!-- HTML untuk form edit pengeluaran dengan Bootstrap 5 -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran | Sicakep</title>
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
    <h2 class="text-center mb-4">Edit Pengeluaran</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <div class="card card-custom p-4">
        <form method="POST" action="editExpense.php?id=<?= $expenseId ?>">
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Pengeluaran</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <!-- Menampilkan semua kategori lainnya -->
                    <?php foreach ($categories as $categoryOption): ?>
                        <option value="<?= $categoryOption['id']; ?>" <?= $categoryOption['id'] == $category['id'] ? 'selected' : ''; ?>>
                            <?= $categoryOption['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="amount" name="amount" value="<?= $expense['amount']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= $expense['description']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= $expense['date']; ?>" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Update Pengeluaran</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
