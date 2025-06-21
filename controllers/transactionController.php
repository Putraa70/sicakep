<?php
// transactionController.php - Controller untuk riwayat transaksi

require_once(__DIR__ . '/../models/transaction.php');  // Memanggil model transaction

// Fungsi untuk menambah transaksi
function addTransaction($userId, $transactionType, $transactionId, $amount, $description, $date, $categoryId) {
    return Transaction::addTransaction($userId, $transactionType, $transactionId, $amount, $description, $date, $categoryId);
}

// Fungsi untuk mendapatkan semua transaksi berdasarkan ID pengguna
function getTransactions($userId) {
    return Transaction::getAllTransactions($userId);  // Memanggil model Transaction untuk mengambil data transaksi
}

// Fungsi untuk menghapus transaksi berdasarkan ID
function deleteTransaction($transactionId) {
    return Transaction::deleteTransaction($transactionId);
}

// Fungsi untuk mendapatkan transaksi berdasarkan ID
function getTransactionById($transactionId) {
    return Transaction::getTransactionById($transactionId);
}

// Fungsi untuk memperbarui transaksi
function updateTransaction($transactionId, $userId, $transactionType, $transactionIdParam, $amount, $description, $date, $categoryId) {
    return Transaction::updateTransaction($transactionId, $userId, $transactionType, $transactionIdParam, $amount, $description, $date, $categoryId);
}
?>