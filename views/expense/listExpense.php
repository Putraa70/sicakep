<?php
// listExpense.php - Halaman untuk melihat pengeluaran

require_once '../../config/session.php';
require_once '../../controllers/expenseController.php';

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
    /* Mengatur body dan html untuk mendukung layout flex */
    html,
    body {
        height: 100%;
        /* Mengatur tinggi body dan html agar memenuhi layar */
        margin: 0;
        /* Menghilangkan margin default */
    }

    body {
        display: flex;
        flex-direction: column;
        /* Menyusun elemen-elemen halaman secara vertikal */
    }

    main {
        flex-grow: 1;
        /* Konten utama mengisi ruang yang tersedia */
        overflow-y: auto;
        /* Membuat konten dapat di-scroll */
    }

    footer {
        background-color: #f8f9fa;
        /* Warna latar belakang footer */
        padding-top: 1rem;
        padding-bottom: 1rem;
        text-align: center;
        width: 100%;
        margin-top: auto;
        /* Footer selalu berada di bawah */
    }

    footer .container {
        text-align: center;
    }

    .table-custom {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                    <?php $category = getCategoryById($expense['category_id']); ?>
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