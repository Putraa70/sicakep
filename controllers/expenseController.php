<?php
// expenseController.php - Controller untuk pengeluaran

// expenseController.php
require_once(__DIR__ . '/../models/expense.php');


// Fungsi untuk menambah pengeluaran
function addExpense($userId, $categoryId, $amount, $description, $date) {
    return Expense::addExpense($userId, $categoryId, $amount, $description, $date);
}

// Fungsi untuk mendapatkan semua pengeluaran
function getExpenses($userId) {
    return Expense::getAllExpenses($userId);
}

// Fungsi untuk mendapatkan pengeluaran berdasarkan ID
function getExpense($expenseId) {
    return Expense::getExpenseById($expenseId);
}

// Fungsi untuk memperbarui pengeluaran
function updateExpense($expenseId, $categoryId, $amount, $description, $date) {
    return Expense::updateExpense($expenseId, $categoryId, $amount, $description, $date);
}



// Fungsi untuk mendapatkan kategori berdasarkan ID
function getCategoryById($categoryId) {
    return Category::getCategoryById($categoryId);  // Memanggil model Category untuk mendapatkan kategori berdasarkan ID
}

// Fungsi untuk menghapus pengeluaran
function deleteExpense($expenseId) {
    return Expense::deleteExpense($expenseId);
}
// function getCategoryById($categoryId) {
//     return Category::getCategoryById($categoryId);  // Memanggil model Category
// }
?>
