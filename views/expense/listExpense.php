<?php
// listExpense.php - Halaman untuk melihat pengeluaran

require_once '../../config/session.php';
require_once '../../controllers/expenseController.php';
require_once '../../models/category.php';

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php'); // Jika belum login, arahkan ke halaman login
    exit;
}

$expenses = getExpenses(getUserId()); // Mendapatkan semua pengeluaran pengguna
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengeluaran | Sicakep</title>
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

    <!-- Konten Utama -->
    <main>
        <div class="container mt-5">
            <h2 class="text-center">Daftar Pengeluaran</h2>
            <a href="addExpense.php" class="btn btn-primary mb-3">Tambah Pengeluaran</a>
            <table class="table table-custom table-striped">
                <thead>
                    <tr>
                        <th scope="col">Kategori</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $expense): ?>
                    <?php $category = Category::getCategoryById($expense['category_id']); ?>
                    <tr>
                        <td><?= htmlspecialchars($category['name']); ?></td>
                        <td><?= number_format($expense['amount'], 0, ',', '.'); ?></td>
                        <td><?= htmlspecialchars($expense['description']); ?></td>
                        <td><?= htmlspecialchars($expense['date']); ?></td>
                        <td>
                            <a href="editExpense.php?id=<?= $expense['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="deleteExpense.php?id=<?= $expense['id']; ?>"
                                class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Include Footer -->
    <?php include('../includes/footer.php'); ?>

</body>

</html>