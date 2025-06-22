 
<?php
// db.php - Konfigurasi koneksi database

// Konfigurasi koneksi database
define('DB_HOST', 'localhost');
define('DB_NAME', 'sicakepweb');
define('DB_USER', 'root');
define('DB_PASS', ''); // Ganti dengan password database Anda

try {
    // Membuat koneksi PDO
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    // Mengatur error mode untuk menampilkan kesalahan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Menyiapkan charset untuk mencegah masalah encoding
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Menangani error koneksi jika gagal
    die("Koneksi gagal: " . $e->getMessage());
}
?>
