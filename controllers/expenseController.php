<?php
// expenseController.php - Controller untuk pengeluaran

require_once(__DIR__ . '/../models/expense.php');

// Fungsi untuk mendapatkan semua pengeluaran
function getExpenses($userId) {
    return Expense::getAllExpenses($userId);
}

// Fungsi untuk menambah pengeluaran
function addExpense($userId, $categoryId, $amount, $description, $date) {
    return Expense::addExpense($userId, $categoryId, $amount, $description, $date);
}

// Fungsi untuk mendapatkan pengeluaran berdasarkan ID
function getExpenseById($expenseId) {
    return Expense::getExpenseById($expenseId);
}

// Fungsi untuk memperbarui pengeluaran
function updateExpense($expenseId, $categoryId, $amount, $description, $date) {
    return Expense::updateExpense($expenseId, $categoryId, $amount, $description, $date);
}

// Fungsi untuk menghapus pengeluaran
function deleteExpense($expenseId) {
    return Expense::deleteExpense($expenseId);
}

// Fungsi untuk mendapatkan ringkasan pengeluaran berdasarkan tanggal
function getExpenseSummaryByUser($userId) {
    return Expense::getExpenseSummaryByUser($userId);
}

// Fungsi untuk mendapatkan ringkasan pengeluaran bulanan
function getMonthlyExpenseSummaryByUser($userId) {
    return Expense::getMonthlyExpenseSummaryByUser($userId);
}
?>