<?php
// categoryController.php - Controller untuk kategori pengeluaran/pemasukan

require_once(__DIR__ . '/../models/category.php');


// Fungsi untuk mendapatkan semua kategori
function getCategories() {
    $categories = Category::getAllCategories();
    return $categories;
}


// Fungsi untuk mendapatkan kategori berdasarkan ID
// function getCategoryById($categoryId) {
//     return Category::getCategoryById($categoryId);  // Memanggil model Category untuk mendapatkan kategori berdasarkan ID
// }
// Fungsi untuk menambah kategori baru
function addCategory($name) {
    return Category::addCategory($name);
}

// Fungsi untuk memperbarui kategori
function updateCategory($categoryId, $name) {
    return Category::updateCategory($categoryId, $name);
}

// Fungsi untuk menghapus kategori
function deleteCategory($categoryId) {
    return Category::deleteCategory($categoryId);
}

?>
