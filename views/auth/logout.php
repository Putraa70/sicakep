<?php
// logout.php - Halaman untuk logout pengguna

require_once dirname(__DIR__, 2) . '/config/session.php'; // Pastikan file session.php dimuat

// Hapus semua session data
session_unset();  // Menghapus semua data session
session_destroy();  // Menghancurkan session

// Redirect ke halaman login setelah logout
header('Location: login.php');  // Arahkan pengguna ke halaman login
exit; // Menghentikan eksekusi script setelah redireksi
?>
