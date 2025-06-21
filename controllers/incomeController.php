<?php
// incomeController.php - Controller untuk pemasukan

require_once(__DIR__ . '/../models/income.php');
require_once(__DIR__ . '/../models/transaction.php');

// Fungsi untuk mendapatkan pemasukan berdasarkan ID pengguna
function getIncomesByUser($userId) {
    return Income::getAllIncomesByUser($userId); // Memanggil model Income untuk mengambil data pemasukan
}

// Fungsi untuk menambah pemasukan
function addIncome($userId, $categoryId, $amount, $description, $date) {
    $result = Income::addIncome($userId, $categoryId, $amount, $description, $date);
    if ($result) {
        // Get the last inserted income ID
        global $pdo;
        $incomeId = $pdo->lastInsertId();
        // Log to transaction history
        Transaction::addTransaction($userId, 'income', $incomeId, $amount, $description, $date, $categoryId);
    }
    return $result;
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
    $result = Income::updateIncome($incomeId, $categoryId, $amount, $description, $date);
    if ($result) {
        // Log to transaction history
        // Assuming userId can be fetched from income record
        $income = Income::getIncomeById($incomeId);
        if ($income) {
            Transaction::addTransaction($income['user_id'], 'income', $incomeId, $amount, $description, $date, $categoryId);
        }
    }
    return $result;
}

// Fungsi untuk menghapus pemasukan
function deleteIncome($incomeId) {
    // Get income details before deletion for logging
    $income = Income::getIncomeById($incomeId);
    $result = Income::deleteIncome($incomeId);
    if ($result && $income) {
        Transaction::addTransaction($income['user_id'], 'income', $incomeId, $income['amount'], $income['description'], $income['date'], $income['category_id']);
    }
    return $result;
}
function getIncomeById($incomeId) {
    return Income::getIncomeById($incomeId);  // Memanggil model Income untuk mendapatkan data pemasukan
}

// Fungsi untuk mendapatkan ringkasan pemasukan berdasarkan tanggal
function getIncomeSummaryByUser($userId) {
    return Income::getIncomeSummaryByUser($userId);
}
?>