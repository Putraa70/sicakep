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

<?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
<!-- Toast Modern Bootstrap -->
<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
  <div class="toast show align-items-center text-bg-success border-0 shadow" role="alert" id="successToast" data-bs-autohide="true" data-bs-delay="2000">
    <div class="d-flex">
      <div class="toast-body">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle me-2" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.904 11.803a.5.5 0 0 0 .707 0l4-4a.5.5 0 1 0-.707-.707L7.5 10.293 5.646 8.439a.5.5 0 1 0-.707.707l2 2z"/>
        </svg>
        <strong>Data berhasil dihapus!</strong>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengeluaran | Sicakep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    html, body { height: 100%; }
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
    .content-wrapper {
        background-color: var(--card-bg-color);
        padding: 2.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
    }
    .page-title {
        color: var(--primary-color-dark);
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
    }
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
    .btn-success {
        background-color: var(--accent-color-success);
        border-color: var(--accent-color-success);
    }
    .btn-danger {
        background-color: var(--accent-color-danger);
        border-color: var(--accent-color-danger);
    }
    .table-wrapper { overflow-x: auto; }
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
    .table th, .table td {
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
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>

    <!-- Bootstrap Bundle with Popper for Toast -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Optional: Ulangi toast show (mengatasi bug pada reload)
        var toastEl = document.getElementById('successToast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    </script>
</body>

</html>
