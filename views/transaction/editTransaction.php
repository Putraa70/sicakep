<?php
// editTransaction.php - Halaman untuk mengedit transaksi

require_once '../../config/session.php';
require_once '../../controllers/transactionController.php';
require_once '../../controllers/categoryController.php';

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: transactionHistory.php');
    exit;
}

$transactionId = $_GET['id'];
$transaction = getTransactionById($transactionId);
if (!$transaction) {
    header('Location: transactionHistory.php');
    exit;
}

$categories = getCategories();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $transaction['user_id']; // Assuming user_id is not editable
    $transactionType = $_POST['transaction_type'];
    $transactionIdParam = $transaction['transaction_id']; // Assuming transaction_id is not editable
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $categoryId = $_POST['category_id'];

    if (empty($amount) || empty($description) || empty($date) || empty($categoryId) || empty($transactionType)) {
        $error = 'Semua field harus diisi.';
    } else {
        if (updateTransaction($transactionId, $userId, $transactionType, $transactionIdParam, $amount, $description, $date, $categoryId)) {
            header('Location: transactionHistory.php');
            exit;
        } else {
            $error = 'Gagal memperbarui transaksi. Silakan coba lagi.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Transaksi | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center">Edit Transaksi</h2>
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="editTransaction.php?id=<?= htmlspecialchars($transactionId); ?>">
            <div class="mb-3">
                <label for="transaction_type" class="form-label">Jenis Transaksi</label>
                <select class="form-select" id="transaction_type" name="transaction_type" required>
                    <option value="income" <?= $transaction['transaction_type'] === 'income' ? 'selected' : ''; ?>>
                        Pemasukan</option>
                    <option value="expense" <?= $transaction['transaction_type'] === 'expense' ? 'selected' : ''; ?>>
                        Pengeluaran</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id']; ?>"
                        <?= $transaction['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($category['name']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="amount" name="amount"
                    value="<?= htmlspecialchars($transaction['amount']); ?>" required />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    required><?= htmlspecialchars($transaction['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="date" name="date"
                    value="<?= htmlspecialchars($transaction['date']); ?>" required />
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="transactionHistory.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>