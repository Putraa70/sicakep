<?php
// transactionController.php - Controller untuk riwayat transaksi

require_once(__DIR__ . '/../models/transaction.php');  // Memanggil model transaction

// Fungsi untuk menambah transaksi
function addTransaction($userId, $transactionType, $transactionId, $amount, $description, $date) {
    return Transaction::addTransaction($userId, $transactionType, $transactionId, $amount, $description, $date);
}

// Fungsi untuk mendapatkan semua transaksi berdasarkan ID pengguna
function getTransactions($userId) {
    return Transaction::getAllTransactions($userId);  // Memanggil model Transaction untuk mengambil data transaksi
}
?>
