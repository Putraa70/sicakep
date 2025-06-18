<?php
// transaction.php - Model untuk riwayat transaksi

require_once(__DIR__ . '/../config/db.php');  // Memastikan koneksi database tersedia

class Transaction {
    // Fungsi untuk menambah riwayat transaksi
    public static function addTransaction($userId, $transactionType, $transactionId, $amount, $description, $date) {
        global $pdo;

        $query = "INSERT INTO transaction_history (user_id, transaction_type, transaction_id, amount, description, date, category_id) 
                  VALUES (:user_id, :transaction_type, :transaction_id, :amount, :description, :date, :category_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':transaction_type', $transactionType);
        $stmt->bindParam(':transaction_id', $transactionId);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':category_id', $categoryId);  // Pastikan ini di-bind jika ada category_id

        return $stmt->execute();
    }

    // Fungsi untuk mendapatkan riwayat transaksi berdasarkan ID pengguna
    public static function getAllTransactions($userId) {
        global $pdo;

        // Pastikan query sudah benar dan dieksekusi
        $query = "SELECT th.*, c.name AS category_name
                  FROM transaction_history th
                  LEFT JOIN categories c ON th.category_id = c.id
                  WHERE th.user_id = :user_id 
                  ORDER BY th.date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Mengembalikan semua data transaksi pengguna
    }
}
?>
