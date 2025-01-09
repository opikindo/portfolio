<?php
// Konfigurasi Database
$host = "localhost"; // Nama host
$user = "root"; // Username database
$password = ""; // Password database
$database = "CVTaufikAkbar"; // Nama database
// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);
// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Query untuk mengambil data dari tabel
$sql = "SELECT id, nama, jenis_kelamin, alamat, deskripsi, foto FROM users";
$result = $conn->query($sql);
// ?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container">
            <a class="navbar-brand text-white" href="">2203010062 MUHAMAD TAUFIK AKBAR C</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href=""><b>HOME</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#education-section"><b>EDUCATION</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#project-section"><b>PROJECT</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact"><b>CONTACT</b></a></li>
                    <li class="nav-item">
                        <button class="btn hire-btn"><b>Hire me</b></button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Hero Text -->
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 hero-content">
                    <h1><span>I’m</span> <br>
                        <?= $row['nama'] ?>
                    </h1>
                    <!-- Tampilkan Deskripsi -->
                    <p class="my-3">
                        <?= $row['deskripsi'] ?>
                    </p>
                    <a href="https://drive.google.com/uc?export=download&id=1jPZ2PBT_nZ2X2xGsYW6FaPvpL02yTuCk" class="btn btn-custom">Download CV</a>
                </div>
                <!-- Hero Image -->
                <div class="col-md-6 text-center hero-image">
                    <img src="../backend/assets/users/images/<?= $row['foto'] ?>" alt="Foto" width="100">
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </section>
    <section class="education-section mt-3" id="education-section">
        <h1 class="text-center">Education</h1>
        <!-- keterangan boleh diubah -->
        <p class="text-center">Daftar Pendidikan Saya</p>
        <div class="container-fluid">
            <table class="table">
                <thead>
                    <tr class="table-dark"> 
                        <th class="table-dark">No</th>
                        <th class="table-dark">Pendidikan</th>
                        <th class="table-dark">Tahun</th>
                        <th class="table-dark">Nama Sekolah / Kampus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php require 'functions.php'; ?>
                    <?php $educations = get_educations(); ?>
                    <?php $no=1; ?>
                    <?php if(count($educations)>0): ?>
                        <?php foreach($educations as $education): ?>
                            <tr class="table-dark">
                                <th><?= $no++; ?></th>
                                <td class="table-dark"><?= $education["pendidikan"]; ?></td>
                                <td class="table-dark"><?= $education["tahun"]; ?></td>
                                <td class="table-dark"><?= $education["nama_kampus"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-light">Tidak ada data pendidikan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="project-section mt-3" id="project-section">
        <div class="container">
            <h1 class="text-center">Projects</h1>
            <div class="row mt-3">
                <?php $projects = get_projects(); ?>
                <?php foreach($projects as $project): ?>
                    
                    <div class="col-md-4">
                        <div class="card text-dark" style="width: 18rem; height: 250px; overflow: hidden;">
                            <img src="../backend/assets/projects/images/<?=$project['gambar_project']; ?>" class="card-img-top" alt="..." style="object-fit: cover; height: 50%;">
                            <div class="card-body" style="height: 50%; overflow: hidden;">
                                <h5 class="card-title"><?= $project["nama_project"]; ?></h5>
                                <p class="card-text" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= $project["deskripsi_project"]; ?></p>
                                <a href="#" class="btn text-secondary"><?= $project["link_project"]; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <footer class="mt-5" id="contact">
        <div class="container-fluid bg-body-tertiary text-dark pt-3">
            <div class="row mb-4">
                <div class="col-md-5">
                    <h1>Contact</h1>
                    <div class="address row">
                        <span><b>Address</b></span>
                        <span>Jl air tanjung, Tasikmalaya</span>
                        <span>Jawa Barat, Indonesia</span>
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
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>