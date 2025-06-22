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
    /* =========================================
       CSS Terpadu untuk Halaman Daftar - Sicakep
       ========================================= */

    /* 1. Root Variables (Menyesuaikan dengan tema dashboard) */
    :root {
        --primary-color: #563D7C;
        --primary-color-dark: #3B2A53;
        --accent-color-success: #198754;
        --accent-color-danger: #dc3545;
        --accent-color-warning: #ffc107;
        --text-color-light: #ffffff;
        --body-bg-color: #f0f2f5;
        --card-bg-color: #ffffff;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --border-radius: 0.75rem;
    }

    /* 2. Body dan Layout Utama */
    html,
    body {
        height: 100%;
    }

    body {
        background-color: var(--body-bg-color);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        display: flex;
        flex-direction: column;
    }

    main {
        flex-grow: 1;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    /* 3. Wrapper Konten Utama */
    .content-wrapper {
        background-color: var(--card-bg-color);
        padding: 2.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
    }

    /* 4. Judul Halaman */
    .page-title {
        color: var(--primary-color-dark);
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* 5. Tombol "Tambah" */
    .btn-add {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background-color: var(--primary-color-dark);
        border-color: var(--primary-color-dark);
        transform: translateY(-2px);
    }

    /* Tombol Success & Danger di halaman History */
    .btn-success {
        background-color: var(--accent-color-success);
        border-color: var(--accent-color-success);
    }

    .btn-danger {
        background-color: var(--accent-color-danger);
        border-color: var(--accent-color-danger);
    }


    /* 6. Styling Tabel */
    .table-wrapper {
        overflow-x: auto;
        /* Membuat tabel bisa di-scroll horizontal di layar kecil */
    }

    .table {
        margin-top: 1.5rem;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .table thead th {
        background-color: var(--primary-color);
        color: var(--text-color-light);
        border: none;
        vertical-align: middle;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table th,
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table tbody tr {
        transition: background-color 0.2s ease-in-out;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table td .btn {
        margin-right: 5px;
        margin-bottom: 5px;
    }

    /* 7. Badge untuk Jenis Transaksi */
    .badge.type-income {
        background-color: var(--accent-color-success) !important;
        color: white;
    }

    .badge.type-expense {
        background-color: var(--accent-color-danger) !important;
        color: white;
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