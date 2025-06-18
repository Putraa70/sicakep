<?php
// incomeController.php - Controller untuk pemasukan

require_once(__DIR__ . '/../models/income.php');

// Fungsi untuk mendapatkan pemasukan berdasarkan ID pengguna
function getIncomesByUser($userId) {
    return Income::getAllIncomesByUser($userId); // Memanggil model Income untuk mengambil data pemasukan
}

// Fungsi untuk menambah pemasukan
function addIncome($userId, $categoryId, $amount, $description, $date) {
    return Income::addIncome($userId, $categoryId, $amount, $description, $date);
}

// Fungsi untuk mendapatkan semua pemasukan
function getIncomes($userId) {
    return Income::getAllIncomes($userId);
}

// Fungsi untuk mendapatkan pemasukan berdasarkan ID
function getIncome($incomeId) {
    return Income::getIncomeById($incomeId);
}

// Fungsi untuk memperbarui pemasukan
function updateIncome($incomeId, $categoryId, $amount, $description, $date) {
    return Income::updateIncome($incomeId, $categoryId, $amount, $description, $date);
}

// Fungsi untuk menghapus pemasukan
function deleteIncome($incomeId) {
    return Income::deleteIncome($incomeId);
}
function getIncomeById($incomeId) {
    return Income::getIncomeById($incomeId);  // Memanggil model Income untuk mendapatkan data pemasukan
}
?>
