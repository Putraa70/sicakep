<?php
// session.php - Mengelola session pengguna

// Fungsi untuk memulai session (jika belum dimulai)
function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Fungsi untuk login
function login($userId, $username) {
    startSession();
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = true;
}

// Fungsi untuk logout
function logout() {
    startSession();
    session_unset();  // Menghapus semua data session
    session_destroy();  // Menghancurkan session
}

// Fungsi untuk memeriksa apakah pengguna sudah login
function isLoggedIn() {
    startSession();
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Fungsi untuk mendapatkan ID pengguna
function getUserId() {
    startSession();
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

// Fungsi untuk mendapatkan username pengguna
function getUsername() {
    startSession();
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}
?>
