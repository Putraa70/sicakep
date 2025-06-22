<?php
// categoryController.php - Controller untuk kategori pengeluaran/pemasukan

require_once(__DIR__ . '/../models/category.php');

function getCategories() {
    return Category::getAllCategories();
}

function addCategory($name) {
    return Category::addCategory($name);
}
function updateCategory($categoryId, $name, $type) {
    return Category::updateCategory($categoryId, $name, $type);
}

function getCategoriesByType($type) {
    return Category::getCategoriesByType($type);
}


function deleteCategory($categoryId) {
    return Category::deleteCategory($categoryId);
}
?>
