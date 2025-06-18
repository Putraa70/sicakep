<?php
// dashboard.php - Halaman utama setelah login

require_once '../config/session.php';  // Perbaiki path ke session.php

// Cek apakah pengguna sudah login
if (!isLoggedIn()) {
    // Jika belum login, arahkan ke halaman login
    header('Location: /views/auth/login.php');
    exit; // Menghentikan eksekusi setelah redirect
}

$username = getUsername(); // Ambil nama pengguna dari session
?>

<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sicakep</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
    /* CSS Kustom untuk penyempurnaan desain */
    body {
        background-color: #f8f9fa;
        /* Latar belakang netral */
    }

    .main-header {
        background: linear-gradient(135deg, #563D7C 0%, #3B2A53 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2.5rem;
        border-bottom-left-radius: 1.5rem;
        border-bottom-right-radius: 1.5rem;
    }

    .card-feature {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        height: 100%;
    }

    .card-feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
    }

    .card-feature .card-header {
        background-color: transparent;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
        font-size: 1.2rem;
        color: #343a40;
    }

    .card-feature .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-feature .icon-container {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #563D7C;
    }

    .btn-primary-custom {
        background-color: #563D7C;
        border-color: #563D7C;
    }

    .btn-primary-custom:hover {
        background-color: #453163;
        border-color: #453163;
    }

    .footer {
        background-color: #343a40;
        color: #f8f9fa;
    }
    </style>
</head>

<body class="d-flex flex-column h-100">

    <?php include('includes/header.php'); // Navbar utama ?>

    <main class="flex-shrink-0">
        <header class="main-header text-center">
            <div class="container">
                <h1 class="display-5">Selamat Datang, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!</h1>
                <p class="lead">Kelola keuangan Anda dengan lebih cerdas dan teratur bersama Sicakep.</p>
            </div>
        </header>

        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card card-feature text-center">
                        <div class="card-header">
                            Pengeluaran
                        </div>
                        <div class="card-body p-4">
                            <div>
                                <div class="icon-container">
                                    <i class="fas fa-arrow-circle-up"></i>
                                </div>
                                <p class="card-text mb-4">Catat dan analisis semua pengeluaran Anda untuk kontrol
                                    anggaran yang lebih baik.</p>
                            </div>
                            <a href="expense/listExpense.php" class="btn btn-primary-custom w-100">Kelola
                                Pengeluaran</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-feature text-center">
                        <div class="card-header">
                            Pemasukan
                        </div>
                        <div class="card-body p-4">
                            <div>
                                <div class="icon-container">
                                    <i class="fas fa-arrow-circle-down"></i>
                                </div>
                                <p class="card-text mb-4">Monitor semua sumber pemasukan untuk mendapatkan gambaran
                                    finansial yang lengkap.</p>
                            </div>
                            <a href="income/listIncome.php" class="btn btn-primary-custom w-100">Kelola Pemasukan</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="card card-feature text-center">
                        <div class="card-header">
                            Kategori Keuangan
                        </div>
                        <div class="card-body p-4">
                            <div>
                                <div class="icon-container">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <p class="card-text mb-4">Buat dan kelola kategori transaksi untuk pelacakan yang lebih
                                    terperinci.</p>
                            </div>
                            <a href="../views/transaction/transactionHistory.php"
                                class="btn btn-primary-custom w-100">Kelola Kategori</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php include('includes/footer.php'); // Footer utama ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>