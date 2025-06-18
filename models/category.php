<?php
// category.php - Model untuk kategori pengeluaran dan pemasukan

require_once(__DIR__ . '/../config/db.php');
class Category {
    // Fungsi untuk mendapatkan semua kategori
    public static function getAllCategories() {
        global $pdo;

        $query = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mendapatkan kategori berdasarkan ID
    public static function getCategoryById($categoryId) {
        global $pdo;

        $query = "SELECT * FROM categories WHERE id = :category_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk menambah kategori
    public static function addCategory($name) {
        global $pdo;

        $query = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    // Fungsi untuk memperbarui kategori
    public static function updateCategory($categoryId, $name) {
        global $pdo;

        $query = "UPDATE categories SET name = :name WHERE id = :category_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $categoryId);

        return $stmt->execute();
    }

    // Fungsi untuk menghapus kategori
    public static function deleteCategory($categoryId) {
        global $pdo;

        $query = "DELETE FROM categories WHERE id = :category_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);

        return $stmt->execute();
    }
}
?>
