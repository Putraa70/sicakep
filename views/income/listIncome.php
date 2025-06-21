<?php
// listIncome.php - Halaman untuk melihat daftar pemasukan

require_once '../../config/session.php';
require_once '../../controllers/incomeController.php';  // Memanggil controller pemasukan

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    header('Location: ../auth/login.php'); // Jika belum login, arahkan ke halaman login
    exit;
}

$incomes = getIncomesByUser(getUserId()); // Mendapatkan daftar pemasukan berdasarkan ID pengguna

// Definisikan array kategori sesuai dengan opsi di addIncome.php
$categories = [
    1 => 'Gaji',
    2 => 'Usaha',
    3 => 'Investasi'
];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemasukan | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <h2 class="text-center">Daftar Pemasukan</h2>
        <a href="addIncome.php" class="btn btn-primary mb-3">Tambah Pemasukan</a>
        <table class="table table-striped">
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
                <?php foreach ($incomes as $income): ?>
                <tr>
                    <td><?= isset($categories[$income['category_id']]) ? htmlspecialchars($categories[$income['category_id']]) : 'Unknown'; ?>
                    </td>
                    <td><?= number_format($income['amount'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($income['description']); ?></td>
                    <td><?= htmlspecialchars($income['date']); ?></td>
                    <td>
                        <a href="editIncome.php?id=<?= $income['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="deleteIncome.php?id=<?= $income['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include('../includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>