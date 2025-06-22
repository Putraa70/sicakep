<?php
require_once(__DIR__ . '/../../config/session.php');
require_once '../../controllers/transactionController.php';

if (!isLoggedIn()) {
    header('Location: /sicakep/views/auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transactionId = $_POST['transaction_id'];
    deleteTransaction($transactionId);
    header("Location: transactionHistory.php");
    exit;
}

$transactions = getTransactions(getUserId());
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* CSS bisa copy dari yang sebelumnya, ini ringkas */
    .badge.type-income {background: #198754 !important; color: #fff;}
    .badge.type-expense {background: #dc3545 !important; color: #fff;}
    </style>
</head>
<body>
<?php include('../includes/header.php'); ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Riwayat Transaksi</h2>
    <div class="mb-3 text-center">
        <a href="../expense/addExpense.php" class="btn btn-danger mb-2">Tambah Pengeluaran</a>
        <a href="../income/addIncome.php" class="btn btn-success mb-2">Tambah Pemasukan</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($transactions)): ?>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= htmlspecialchars($transaction['category_name']); ?></td>
                <td><?= number_format($transaction['amount'], 0, ',', '.'); ?></td>
                <td><?= htmlspecialchars($transaction['description']); ?></td>
                <td><?= htmlspecialchars($transaction['date']); ?></td>
                <td>
                    <span class="badge <?= $transaction['transaction_type'] == 'expense' ? 'type-expense' : 'type-income'; ?>">
                        <?= $transaction['transaction_type'] == 'expense' ? 'Pengeluaran' : 'Pemasukan'; ?>
                    </span>
                </td>
                <td>
                    <!-- Edit ke halaman sesuai tipe transaksi -->
                    <?php if($transaction['transaction_type']=='expense'): ?>
                        <a href="../expense/editExpense.php?id=<?= $transaction['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php else: ?>
                        <a href="../income/editIncome.php?id=<?= $transaction['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php endif; ?>
                    <form method="POST" action="transactionHistory.php" onsubmit="return confirm('Yakin ingin menghapus riwayat transaksi ini?');" style="display:inline;">
                        <input type="hidden" name="transaction_id" value="<?= $transaction['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include('../includes/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
