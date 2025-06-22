<?php
// deleteIncome.php - Menghapus data pemasukan

require_once '../../config/session.php';
require_once '../../controllers/incomeController.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: listIncome.php?status=gagal&msg=' . urlencode('ID pemasukan tidak valid.'));
    exit;
}

$incomeId = $_GET['id'];
$result = deleteIncome($incomeId);

if ($result) {
    // Sukses
    header('Location: listIncome.php?status=sukses&msg=' . urlencode('Pemasukan berhasil dihapus.'));
    exit;
} else {
    // Gagal
    header('Location: listIncome.php?status=gagal&msg=' . urlencode('Gagal menghapus pemasukan.'));
    exit;
}
?>
