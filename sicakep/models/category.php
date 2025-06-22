<?php
// category.php - Model untuk kategori pengeluaran dan pemasukan

require_once(__DIR__ . '/../config/db.php');

class Category {
    // Mendapatkan kategori berdasarkan ID
    public static function getCategoryById($categoryId) {
        global $pdo;
        $query = "SELECT * FROM categories WHERE id = :category_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambah kategori
    public static function addCategory($name) {
        global $pdo;
        $query = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public static function getAllCategories() {
    global $pdo;
    $query = "SELECT * FROM categories ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ambil kategori berdasar tipe
public static function getCategoriesByType($type) {
    global $pdo;
    $query = "SELECT * FROM categories WHERE type = :type ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Memperbarui kategori

    public static function updateCategory($categoryId, $name, $type) {
    global $pdo;
    $query = "UPDATE categories SET name = :name, type = :type WHERE id = :category_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':category_id', $categoryId);
    return $stmt->execute();
}


    // Menghapus kategori dan semua transaksi terkait
    public static function deleteCategory($categoryId) {
        global $pdo;
        try {
            $pdo->beginTransaction();

            // Hapus data expenses yang pakai kategori ini
            $del1 = $pdo->prepare("DELETE FROM expenses WHERE category_id = :category_id");
            $del1->bindParam(':category_id', $categoryId);
            $del1->execute();

            // Jika ada tabel 'incomes', bisa tambahkan hapus juga di sini

            // Hapus kategorinya
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :category_id");
            $stmt->bindParam(':category_id', $categoryId);
            $stmt->execute();

            $pdo->commit();
            return [
                'success' => true,
                'message' => 'Kategori beserta seluruh transaksi terkait berhasil dihapus.'
            ];
        } catch (PDOException $e) {
            $pdo->rollBack();
            return [
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ];
        }
    }
}
?>
