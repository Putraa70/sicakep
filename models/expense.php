<?php
// expense.php - Model untuk pengeluaran

require_once(__DIR__ . '/../config/db.php');

class Expense {
    // Fungsi untuk menambah pengeluaran
    public static function addExpense($userId, $categoryId, $amount, $description, $date) {
        global $pdo;

        $query = "INSERT INTO expenses (user_id, category_id, amount, description, date) 
                  VALUES (:user_id, :category_id, :amount, :description, :date)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);

        return $stmt->execute();
    }

    // Fungsi untuk mendapatkan semua pengeluaran
    public static function getAllExpenses($userId) {
        global $pdo;

        $query = "SELECT * FROM expenses WHERE user_id = :user_id ORDER BY date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mendapatkan pengeluaran berdasarkan ID
    public static function getExpenseById($expenseId) {
        global $pdo;

        $query = "SELECT * FROM expenses WHERE id = :expense_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':expense_id', $expenseId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk memperbarui pengeluaran
    public static function updateExpense($expenseId, $categoryId, $amount, $description, $date) {
        global $pdo;

        $query = "UPDATE expenses SET category_id = :category_id, amount = :amount, description = :description, 
                  date = :date, updated_at = CURRENT_TIMESTAMP WHERE id = :expense_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':expense_id', $expenseId);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);

        return $stmt->execute();
    }

    // Fungsi untuk menghapus pengeluaran
    public static function deleteExpense($expenseId) {
        global $pdo;

        $query = "DELETE FROM expenses WHERE id = :expense_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':expense_id', $expenseId);

        return $stmt->execute();
    }

    // Fungsi untuk mendapatkan ringkasan pengeluaran berdasarkan tanggal
    public static function getExpenseSummaryByUser($userId) {
        global $pdo;

        $query = "SELECT date, SUM(amount) as total_expense FROM expenses WHERE user_id = :user_id GROUP BY date ORDER BY date ASC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>