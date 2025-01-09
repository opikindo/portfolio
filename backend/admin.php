<?php
session_start();
require '../CV/functions.php';

if(!isset($_SESSION["login"])){
    header("Location: ../CV/login.php");
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <?= inc("styles"); ?>
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        .navbar-dark {
            background-color: #343a40;
        }

        .dashboard-card {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .header {
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="../CV/logout.php" method="POST">
                            <button class="nav-link" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="header mt-4">
        <h1 class="text-center text-dark">Selamat datang di Dashboard Admin</h1>
        <p class="text-center text-muted">Pilih menu di bawah untuk mengelola sistem</p>
    </header>

    <div class="container mt-5">
        <div class="row">
            <!-- Kelola User -->
            <div class="col-md-6 mb-4">
                <a href="manage_users/index.php" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <span>Kelola User</span>
                    </div>
                </a>
            </div>
            <!-- Kelola Akun -->
            <div class="col-md-6 mb-4">
                <a href="manage_accounts/index.php" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <span>Kelola Akun</span>
                    </div>
                </a>
            </div>
            <!-- Kelola Project -->
            <div class="col-md-6 mb-4">
                <a href="manage_projects/index.php" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <span>Kelola Project</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <footer class="mt-5" id="contact">
        <div class="container-fluid bg-body-tertiary text-dark pt-3">
            <div class="row mb-4">
                <div class="col-md-5">
                    <h1>Contact</h1>
                    <div class="address row">
                        <span><b>Address</b></span>
                        <span>123 Main Street, City</span>
                        <span>State Frovince, Country</span>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 d-flex flex-row justify-content-evenly">
                    <span>&copy; 2025 muhamad_taufikakbar.ct.ws</span><span> </span> <span>All rights reserved</span><span> </span><span>Privacy Policy</span>
                </div>
            </div>

        </div>
    </footer>

<?= inc("scripts"); ?>
</body>

</html>