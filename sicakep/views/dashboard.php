<?php
// dashboard.php - Halaman utama setelah login

// Memuat file-file yang diperlukan
require_once '../config/session.php';
require_once '../controllers/incomeController.php';
require_once '../controllers/expenseController.php';

// Cek apakah pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isLoggedIn()) {
    header('Location: /views/auth/login.php');
    exit;
}

// Mengambil data pengguna dari session
$username = getUsername();
$userId = getUserId();
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
    /* =========================================
       Enhanced CSS for Sicakep Dashboard
       ========================================= */
    :root {
        --primary-color: #563D7C;
        --primary-color-dark: #3B2A53;
        --secondary-color: #f8f9fa;
        --text-color-light: #ffffff;
        --text-color-dark: #212529;
        --body-bg-color: #f0f2f5;
        --card-bg-color: #ffffff;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --card-border-radius: 0.75rem;
        --dashboard-layout-ratio: 1.5fr 1fr;
        /* Contoh rasio: Grafik lebih besar */
    }

    body {
        background-color: var(--body-bg-color);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: var(--text-color-dark);
    }

    .h-100 {
        height: 100% !important;
    }

    .main-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color-dark) 100%);
        color: var(--text-color-light);
        padding: 4rem 1.5rem;
        margin-top: -1px;
        border-bottom-left-radius: 2rem;
        border-bottom-right-radius: 2rem;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .main-header .lead {
        opacity: 0.9;
    }

    .dashboard-section {
        display: grid;
        gap: 2rem;
        align-items: stretch;
        margin-top: 1rem;
        position: relative;
        z-index: 10;
        grid-template-columns: var(--dashboard-layout-ratio);
        /* Dirapikan */
    }

    .card-dashboard {
        background-color: var(--card-bg-color);
        border-radius: var(--card-border-radius);
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    /* PERBAIKAN: CSS untuk wrapper kanvas */
    .chart-container {
        position: relative;
        /* Penting untuk Chart.js */
        flex-grow: 1;
        /* Mengisi sisa ruang vertikal */
        min-height: 350px;
        /* Tinggi minimal untuk grafik */
    }

    .card-dashboard h2,
    .card-dashboard h3 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    .summary-card .list-group-item {
        border: none;
        padding: 0.85rem 1rem;
        font-weight: 500;
    }

    .summary-card .badge {
        font-size: 0.9em;
        padding: 0.5em 0.8em;
    }

    /* Sisa CSS lainnya tetap sama */
    .features-section {
        padding: 3rem 0;
    }

    .card-feature {
        background-color: var(--card-bg-color);
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card-feature .card-header {
        background-color: var(--primary-color);
        color: var(--text-color-light);
        font-weight: 600;
        border-top-left-radius: var(--card-border-radius);
        border-top-right-radius: var(--card-border-radius);
        border-bottom: none;
    }

    .card-feature .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .card-feature .icon-container {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .btn-primary-custom {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--text-color-light);
        font-weight: 600;
        padding: 0.75rem 1rem;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary-custom:hover {
        background-color: var(--primary-color-dark);
        border-color: var(--primary-color-dark);
        color: var(--text-color-light);
    }

    @media (max-width: 992px) {
        .dashboard-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .main-header {
            padding: 3rem 1rem;
            border-bottom-left-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
        }

        .dashboard-section {
            margin-top: -1.5rem;
        }
    }
    </style>
</head>

<body class="d-flex flex-column h-100">

    <?php include('includes/header.php'); ?>

    <main class="flex-shrink-0">
        <header class="main-header">
            <div class="container">
                <h1 class="display-5">Selamat Datang, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!</h1>
                <p class="lead">Kelola keuangan Anda dengan lebih cerdas dan teratur bersama Sicakep.</p>
            </div>
        </header>

        <div class="container">
            <div class="dashboard-section">
                <div class="card-dashboard">
                    <h2 class="text-center">Grafik Pemasukan & Pengeluaran</h2>
                    <div class="chart-container">
                        <canvas id="incomeExpenseChart"></canvas>
                    </div>
                </div>

                <div class="card-dashboard summary-card">
                    <h3 class="text-center">Ringkasan Bulanan</h3>
                    <?php
                    $monthlyIncomeSummary = getMonthlyIncomeSummaryByUser($userId);
                    $monthlyExpenseSummary = getMonthlyExpenseSummaryByUser($userId);
                    $currentMonth = date('Y-m');
                    $totalIncome = 0;
                    foreach ($monthlyIncomeSummary as $item) {
                        if ($item['month'] === $currentMonth) {
                            $totalIncome = $item['total_income'];
                            break;
                        }
                    }
                    $totalExpense = 0;
                    foreach ($monthlyExpenseSummary as $item) {
                        if ($item['month'] === $currentMonth) {
                            $totalExpense = $item['total_expense'];
                            break;
                        }
                    }
                    $balance = $totalIncome - $totalExpense;
                    ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Pemasukan
                            <span class="badge bg-success rounded-pill">Rp
                                <?= number_format($totalIncome, 0, ',', '.'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Pengeluaran
                            <span class="badge bg-danger rounded-pill">Rp
                                <?= number_format($totalExpense, 0, ',', '.'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Saldo
                            <span class="badge bg-primary rounded-pill">Rp
                                <?= number_format($balance, 0, ',', '.'); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container features-section">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card card-feature text-center">
                        <div class="card-header">Pengeluaran</div>
                        <div class="card-body p-4">
                            <div>
                                <div class="icon-container"><i class="fas fa-arrow-circle-up"></i></div>
                                <p class="card-text mb-4">Catat semua pengeluaran Anda untuk kontrol anggaran yang lebih
                                    baik.</p>
                            </div>
                            <a href="expense/listExpense.php" class="btn btn-primary-custom w-100">Kelola
                                Pengeluaran</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-feature text-center">
                        <div class="card-header">Pemasukan</div>
                        <div class="card-body p-4">
                            <div>
                                <div class="icon-container"><i class="fas fa-arrow-circle-down"></i></div>
                                <p class="card-text mb-4">Monitor semua sumber pemasukan untuk gambaran finansial
                                    lengkap.</p>
                            </div>
                            <a href="income/listIncome.php" class="btn btn-primary-custom w-100">Kelola Pemasukan</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-feature text-center">
                        <div class="card-header">History Transaksi</div>
                        <div class="card-body p-4">
                            <div>
                                <div class="icon-container"><i class="fas fa-history"></i></div>
                                <p class="card-text mb-4">Lihat riwayat lengkap dari semua pemasukan dan pengeluaran
                                    Anda.</p>
                            </div>
                            <a href="../views/transaction/transactionHistory.php"
                                class="btn btn-primary-custom w-100">Lihat History</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 mx-auto">
                    <div class="card card-feature text-center">
                        <div class="card-header">Kategori Keuangan</div>
                        <div class="card-body p-4">
                            <div>
                                <div class="icon-container"><i class="fas fa-tags"></i></div>
                                <p class="card-text mb-4">Buat dan kelola kategori transaksi untuk pelacakan yang
                                    terperinci.</p>
                            </div>
                            <a href="../views/category/listCategory.php" class="btn btn-primary-custom w-100">Kelola
                                Kategori</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include('includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    // Skrip JavaScript sama, tidak perlu diubah
    document.addEventListener('DOMContentLoaded', function() {
        const incomeData = <?= json_encode(getIncomeSummaryByUser($userId)); ?>;
        const expenseData = <?= json_encode(getExpenseSummaryByUser($userId)); ?>;
        const labelsSet = new Set();
        incomeData.forEach(item => labelsSet.add(item.date));
        expenseData.forEach(item => labelsSet.add(item.date));
        const labels = Array.from(labelsSet).sort();
        const incomeMap = new Map(incomeData.map(item => [item.date, item.total_income]));
        const expenseMap = new Map(expenseData.map(item => [item.date, item.total_expense]));
        const incomeValues = labels.map(date => incomeMap.get(date) || 0);
        const expenseValues = labels.map(date => expenseMap.get(date) || 0);
        const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
        const incomeExpenseChart = new Chart(ctx, {
            type: 'line',
            data: {
                /* ...data sama... */
                labels: labels,
                datasets: [{
                        label: 'Pemasukan',
                        data: incomeValues,
                        borderColor: 'rgba(25, 135, 84, 1)',
                        backgroundColor: 'rgba(25, 135, 84, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(25, 135, 84, 1)'
                    },
                    {
                        label: 'Pengeluaran',
                        data: expenseValues,
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(220, 53, 69, 1)'
                    }
                ]
            },
            options: {
                /* ...options sama... */
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah (Rp)'
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    });
    </script>

</body>

</html>