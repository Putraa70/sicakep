<?php
// income.php - Model untuk pemasukan

require_once(__DIR__ . '/../config/db.php');

class Income {
    // Fungsi untuk menambah pemasukan
    public static function addIncome($userId, $categoryId, $amount, $description, $date) {
        global $pdo;

        $query = "INSERT INTO incomes (user_id, category_id, amount, description, date) 
                  VALUES (:user_id, :category_id, :amount, :description, :date)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);

        return $stmt->execute();
    }

    public static function getAllIncomesByUser($userId) {
        global $pdo;

        $query = "SELECT * FROM incomes WHERE user_id = :user_id ORDER BY date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua data pemasukan untuk pengguna tertentu
    }

    // Fungsi untuk mendapatkan semua pemasukan
    public static function getAllIncomes($userId) {
        global $pdo;

        $query = "SELECT * FROM incomes WHERE user_id = :user_id ORDER BY date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mendapatkan pemasukan berdasarkan ID
    public static function getIncomeById($incomeId) {
        global $pdo;

        $query = "SELECT * FROM incomes WHERE id = :income_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':income_id', $incomeId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk memperbarui pemasukan
    public static function updateIncome($incomeId, $categoryId, $amount, $description, $date) {
        global $pdo;

        $query = "UPDATE incomes SET category_id = :category_id, amount = :amount, description = :description, 
                  date = :date, updated_at = CURRENT_TIMESTAMP WHERE id = :income_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':income_id', $incomeId);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);

        return $stmt->execute();
    }

    // Fungsi untuk menghapus pemasukan
    public static function deleteIncome($incomeId) {
        global $pdo;

        $query = "DELETE FROM incomes WHERE id = :income_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':income_id', $incomeId);

        return $stmt->execute();
    }
    
    // Fungsi untuk mendapatkan ringkasan pemasukan berdasarkan tanggal
    public static function getIncomeSummaryByUser($userId) {
        global $pdo;

        $query = "SELECT date, SUM(amount) as total_income FROM incomes WHERE user_id = :user_id GROUP BY date ORDER BY date ASC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mendapatkan ringkasan pemasukan bulanan
    public static function getMonthlyIncomeSummaryByUser($userId) {
        global $pdo;

        $query = "SELECT DATE_FORMAT(date, '%Y-%m') as month, SUM(amount) as total_income FROM incomes WHERE user_id = :user_id GROUP BY month ORDER BY month ASC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>