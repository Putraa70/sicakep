<?php
require_once '../../config/session.php';
require_once '../../controllers/categoryController.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $result = deleteCategory($categoryId);
    $msg = $result['message'];
    $status = $result['success'] ? 'sukses' : 'gagal';
    header("Location: listCategory.php?status=$status&msg=" . urlencode($msg));
} else {
    header("Location: listCategory.php?status=error&msg=" . urlencode('ID kategori tidak ditemukan.'));
}
exit;
?>
