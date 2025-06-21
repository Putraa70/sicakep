<?php
// transactionHistory.php - Halaman untuk melihat riwayat transaksi

// Meng-include session.php untuk memeriksa status login
require_once(__DIR__ . '/../../config/session.php');  // Memastikan path yang benar ke session.php
require_once '../../controllers/transactionController.php';  // Mengambil data transaksi dari controller

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php'); // Jika belum login, arahkan ke halaman login
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transactionId = $_POST['transaction_id'];
    deleteTransaction($transactionId);
    header("Location: transactionHistory.php");
    exit;
}

// Mendapatkan riwayat transaksi pengguna (baik pemasukan dan pengeluaran)
$transactions = getTransactions(getUserId()); // Mendapatkan transaksi pengguna
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .table-custom {
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
        <h2 class="text-center mb-4">Riwayat Transaksi</h2>

        <!-- Tombol untuk menambah pemasukan atau pengeluaran -->
        <div class="mb-3 text-center">
            <a href="../expense/addExpense.php" class="btn btn-danger mb-2">Tambah Pengeluaran</a>
            <a href="../income/addIncome.php" class="btn btn-success mb-2">Tambah Pemasukan</a>
        </div>

        <!-- Tabel Riwayat Transaksi -->
        <table class="table table-custom table-striped">
            <thead>
                <tr>
                    <th scope="col">Kategori</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jenis Transaksi</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction['category_name']; ?></td> <!-- Menampilkan nama kategori -->
                    <td><?= number_format($transaction['amount'], 0, ',', '.'); ?></td>
                    <td><?= $transaction['description']; ?></td>
                    <td><?= $transaction['date']; ?></td>
                    <td>
                        <?= ($transaction['transaction_type'] == 'expense') ? 'Pengeluaran' : 'Pemasukan'; ?>
                    </td>
                    <td>
                        <a href="editTransaction.php?id=<?= $transaction['id']; ?>"
                            class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="transactionHistory.php"
                            onsubmit="return confirm('Yakin ingin menghapus riwayat transaksi ini?');"
                            style="display:inline;">
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