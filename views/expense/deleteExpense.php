<?php
require_once '../../config/session.php';
require_once '../../controllers/expenseController.php';
require_once '../../controllers/categoryController.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Panggil fungsi controller
    deleteExpense($id);

    header("Location: listExpense.php?status=deleted");
    exit;
} else {
    header("Location: listExpense.php");
    exit;
}
?>
