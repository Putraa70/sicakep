<?php
// addIncome.php - Halaman untuk menambah pemasukan

require_once '../../config/session.php';
require_once '../../controllers/incomeController.php';
require_once '../../controllers/categoryController.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryId = $_POST['category_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    if (addIncome(getUserId(), $categoryId, $amount, $description, $date)) {
        header('Location: listIncome.php');
        exit;
    } else {
        $error = 'Gagal menambah pemasukan. Coba lagi.';
    }
}

// Hanya kategori pemasukan (income)
$categories = getCategoriesByType('income');
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemasukan | Sicakep</title>
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
    <h2 class="text-center">Tambah Pemasukan</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    <?php endif; ?>
    
    <div class="card card-custom p-4">
        <form method="POST" action="addIncome.php">
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Pemasukan</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Jumlah</label>
                    <input type="text" class="form-control" id="amount" name="amount" required>
                </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Simpan Pemasukan</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function formatRupiah(angka) {
    return angka.replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('amount');
    // Format saat load halaman (biar enak dilihat)
    if (input.value) {
        input.value = formatRupiah(input.value);
    }
    // Format saat ketik
    input.addEventListener('input', function(e) {
        this.value = formatRupiah(this.value);
    });
    // Hilangkan titik sebelum submit (supaya ke PHP masuk angka mentah)
    input.form.addEventListener('submit', function() {
        input.value = input.value.replace(/\./g, '');
    });
});
</script>

</body>
</html>
