 <?php
// header.php - Menampilkan header dan menu navigasi

require_once dirname(__DIR__, 2) . '/config/session.php';


?>

 <!DOCTYPE html>
 <html lang="id">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sicakep | Aplikasi Keuangan Pribadi</title>
     <!-- Link ke CSS Bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <style>
     body {
         font-family: 'Arial', sans-serif;
         margin: 0;
         background-color: #f8f9fa;
     }

     .navbar {
         border-radius: 0 0 10px 10px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
     }

     .navbar-brand {
         font-size: 1.8rem;
         font-weight: bold;
         color: #007bff !important;
     }

     .navbar-nav .nav-link {
         font-size: 1.1rem;
         padding: 12px 15px;
         color: #495057;
     }

     .navbar-nav .nav-link:hover {
         color: #007bff;
         background-color: #e9ecef;
         border-radius: 5px;
     }

     .btn-custom {
         background-color: #007bff;
         border-color: #007bff;
         color: white;
     }

     .btn-custom:hover {
         background-color: #0056b3;
         border-color: #0056b3;
     }

     .navbar-toggler-icon {
         background-color: #007bff;
     }
     </style>
 </head>

 <body>

     <?php
// header.php - Menampilkan header dan menu navigasi

require_once dirname(__DIR__, 2) . '/config/session.php';
?>
     <!DOCTYPE html>
     <html lang="id">

     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>Sicakep | Aplikasi Keuangan Pribadi</title>
         <!-- Link ke CSS Bootstrap -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
         <style>
         body {
             font-family: 'Arial', sans-serif;
             margin: 0;
             background-color: #f8f9fa;
         }

         .navbar {
             border-radius: 0 0 10px 10px;
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         }

         .navbar-brand {
             font-size: 1.8rem;
             font-weight: bold;
             color: #007bff !important;
         }

         .navbar-nav .nav-link {
             font-size: 1.1rem;
             padding: 12px 15px;
             color: #495057;
         }

         .navbar-nav .nav-link:hover {
             color: #007bff;
             background-color: #e9ecef;
             border-radius: 5px;
         }

         .btn-custom {
             background-color: #007bff;
             border-color: #007bff;
             color: white;
         }

         .btn-custom:hover {
             background-color: #0056b3;
             border-color: #0056b3;
         }

         .navbar-toggler-icon {
             background-color: #007bff;
         }
         </style>
     </head>

     <body>

         <!-- Navbar -->
         <nav class="navbar navbar-expand-lg navbar-light bg-white">
             <div class="container">
                 <a class="navbar-brand" href="/sicakep/views/dashboard.php">Sicakep</a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                     aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarNav">
                     <ul class="navbar-nav ms-auto">
                         <?php if (isLoggedIn()): ?>
                         <!-- Menu untuk pengguna yang sudah login -->
                         <li class="nav-item">
                             <a class="nav-link" href="/views/dashboard.php">Dashboard</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="/views/category/listCategory.php">Kategori</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="/views/expense/listExpense.php">Pengeluaran</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="/views/income/listIncome.php">Pemasukan</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link bg-red" href="/views/auth/logout.php">Logout</a>
                         </li>
                         <?php else: ?>
                         <!-- Menu untuk pengguna yang belum login -->
                         <li class="nav-item">
                             <a class="nav-link" href="/views/auth/login.php">Login</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="/views/auth/register.php">Daftar</a>
                         </li>
                         <?php endif; ?>
                     </ul>
                 </div>
             </div>
         </nav>


         <!-- Start Container -->
         <div class="container mt-5">