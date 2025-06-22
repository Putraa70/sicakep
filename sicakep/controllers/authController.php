 
<?php
// authController.php - Kontroler untuk login, registrasi, dan logout

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/session.php';


// Fungsi untuk registrasi pengguna baru
function register($username, $email, $password) {
    global $pdo;
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk login pengguna
function loginUser($email, $password) {
    global $pdo;
    
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        login($user['id'], $user['username']);
        return true;
    }
    
    return false;
}

// authController.php - Fungsi untuk memeriksa apakah email sudah terdaftar
function isEmailTaken($email) {
    global $pdo;
    
    $query = "SELECT COUNT(*) FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    return $stmt->fetchColumn() > 0; // Jika ada lebih dari 0 hasil, maka email sudah terdaftar
}


// Fungsi untuk logout pengguna
function logoutUser() {
    logout();
}
?>
