<?php
// user.php - Model untuk akun pengguna

require_once '../config/db.php';

class User {
    // Fungsi untuk mendapatkan data pengguna berdasarkan ID
    public static function getUserById($userId) {
        global $pdo;
        
        $query = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mendaftarkan pengguna baru
    public static function register($username, $email, $password) {
        global $pdo;
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        
        return $stmt->execute();
    }

    // Fungsi untuk memeriksa apakah email sudah digunakan
    public static function isEmailTaken($email) {
        global $pdo;
        
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    // Fungsi untuk memperbarui informasi pengguna
    public static function updateUser($userId, $username, $email) {
        global $pdo;
        
        $query = "UPDATE users SET username = :username, email = :email WHERE id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $userId);
        
        return $stmt->execute();
    }

    // Fungsi untuk menghapus akun pengguna
    public static function deleteUser($userId) {
        global $pdo;
        
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        
        return $stmt->execute();
    }
}
?>
