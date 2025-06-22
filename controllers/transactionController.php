<?php
require_once(__DIR__ . '/../config/db.php');

function getTransactions($userId) {
    global $pdo;
    // Ambil pengeluaran
    $expenses = $pdo->prepare("
        SELECT e.id, e.amount, e.description, e.date, 'expense' as transaction_type, c.name AS category_name
        FROM expenses e
        LEFT JOIN categories c ON e.category_id = c.id
        WHERE e.user_id = :user_id
    ");
    $expenses->bindParam(':user_id', $userId);
    $expenses->execute();
    $expenses = $expenses->fetchAll(PDO::FETCH_ASSOC);

    // Ambil pemasukan
    $incomes = $pdo->prepare("
        SELECT i.id, i.amount, i.description, i.date, 'income' as transaction_type, c.name AS category_name
        FROM incomes i
        LEFT JOIN categories c ON i.category_id = c.id
        WHERE i.user_id = :user_id
    ");
    $incomes->bindParam(':user_id', $userId);
    $incomes->execute();
    $incomes = $incomes->fetchAll(PDO::FETCH_ASSOC);

    // Gabungkan dan urutkan DESC (terbaru dulu)
    $all = array_merge($expenses, $incomes);
    usort($all, function($a, $b) {
        // Kalau tanggal sama, urutkan dari id terbesar
        if ($a['date'] === $b['date']) return $b['id'] <=> $a['id'];
        return strtotime($b['date']) <=> strtotime($a['date']);
    });
    return $all;
}

// Fungsi hapus, cek dua tabel
function deleteTransaction($transactionId) {
    global $pdo;
    // Coba hapus dari expenses
    $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = :id");
    $stmt->bindParam(':id', $transactionId);
    $stmt->execute();
    if ($stmt->rowCount() > 0) return true;
    // Coba hapus dari incomes
    $stmt = $pdo->prepare("DELETE FROM incomes WHERE id = :id");
    $stmt->bindParam(':id', $transactionId);
    $stmt->execute();
    return ($stmt->rowCount() > 0);
}
?>
