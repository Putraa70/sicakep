<?php
// editIncome.php - Halaman untuk mengedit pemasukan

require_once '../../config/session.php';
require_once '../../controllers/incomeController.php';  // Memanggil controller pemasukan

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php'); // Jika belum login, arahkan ke halaman login
    exit;
}

$incomeId = $_GET['id'];  // Mendapatkan ID pemasukan dari URL
$income = getIncomeById($incomeId);  // Mendapatkan data pemasukan berdasarkan ID

// Jika data pemasukan tidak ditemukan, arahkan ke halaman list
if (!$income) {
    header('Location: listIncome.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryId = $_POST['category_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Mengupdate pemasukan
    if (updateIncome($incomeId, $categoryId, $amount, $description, $date)) {
        header('Location: listIncome.php');  // Redirect ke halaman list pemasukan setelah berhasil mengedit
        exit;
    } else {
        $error = 'Gagal mengedit pemasukan. Coba lagi.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemasukan | Sicakep</title>
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
    <h2 class="text-center">Edit Pemasukan</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    <?php endif; ?>
    
    <div class="card card-custom p-4">
        <form method="POST" action="editIncome.php?id=<?= $income['id']; ?>">
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Pemasukan</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="1" <?= ($income['category_id'] == 1) ? 'selected' : ''; ?>>Gaji</option>
                    <option value="2" <?= ($income['category_id'] == 2) ? 'selected' : ''; ?>>Usaha</option>
                    <option value="3" <?= ($income['category_id'] == 3) ? 'selected' : ''; ?>>Investasi</option>
                </select>
            </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Jumlah</label>
                    <input type="text" class="form-control" id="amount" name="amount" required>
                </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= $income['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= $income['date']; ?>" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Update Pemasukan</button>
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
