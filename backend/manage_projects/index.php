<?php
require '../../CV/functions.php';

$projects = query("SELECT * FROM projects","SELECT",true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $project_id = $_POST['delete'];
        delete_project($project_id);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $link = $_POST['link'];
        $foto = $_POST['old_foto'];
        if ($_FILES['new_foto']['error'] === 0) {
            echo "hello";
            $foto = basename($_FILES['new_foto']['name']);
            move_uploaded_file($_FILES['new_foto']['tmp_name'], '../assets/projects/images/' . $foto);
        }
        update_project($id,$nama,$deskripsi,$foto,$link);
    } elseif (isset($_POST['create'])) {
        $nama_project = $_POST['new_nama'];
        $deskripsi_project = $_POST['new_deskripsi'];
        $gambar_project = uniqid() . '.' . pathinfo($_FILES['new_gambar']['name'], PATHINFO_EXTENSION);
        $link_project = $_POST['new_link'];
        
        move_uploaded_file($_FILES['new_gambar']['tmp_name'], '../assets/projects/images/' . $gambar_project);
        add_project($nama_project,$deskripsi_project,$gambar_project,$link_project);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage projects</title>
    <!-- Bootstrap CSS -->
    <?= inc("styles"); ?>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-dark {
            background-color: #343a40;
        }

        .dashboard-card {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Table Users -->
    <div class="container-fluid mt-5">
        <div class="project">
            <div class="col-12">
                <!-- Button Tambah User -->
                <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                    Project</button>

                <!-- Tabel Data Users -->
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Project</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($projects)>0): ?>
                        <?php $no = 1; ?>
                        <?php foreach($projects as $project): ?>
                        <tr>
                            <td>
                                <?= $no++; ?>
                            </td>
                            <td>
                                <?= $project['nama_project']; ?>
                            </td>
                            <td>
                                <?= $project['deskripsi_project']; ?>
                            </td>
                            <td>
                                <img src="../assets/projects/images/<?= $project['gambar_project']; ?>" alt="Foto" width="50">
                            </td>
                            <td>
                                <?= $project['link_project']; ?>
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-id="<?= $project['id']; ?>"
                                    data-nama="<?= $project['nama_project']; ?>" 
                                    data-link_project="<?= $project['link_project']; ?>" data-deskripsi="<?= $project['deskripsi_project']; ?>"
                                    data-gambar_project="<?= $project['gambar_project']; ?>">Edit</button>
                                <!-- Tombol Hapus -->
                                <form method="post" style="display:inline;">
                                    <button class="btn btn-danger btn-sm" type="submit" name="delete"
                                        value="<?= $project['id']; ?>">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data project.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" users="3"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="new_foto" class="form-label">Foto (Opsional)</label>
                            <input type="hidden" name="old_foto" id="old_foto">
                            <input type="file" class="form-control" name="new_foto">
                        </div>
                        <div class="mb-3">
                            <label for="edit_link" class="form-label">Link</label>
                            <input type="text" class="form-control" id="edit_link" name="link" required>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="new_nama" class="form-label">Nama Project</label>
                            <input type="text" class="form-control" name="new_nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="new_deskripsi" users="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="new_gambar" class="form-label">Gambar Project</label>
                            <input type="file" class="form-control" name="new_gambar" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_link" class="form-label">Link Project</label>
                            <input type="text" class="form-control" name="new_link" required>
                        </div>
                        
                        
                        <button type="submit" name="create" class="btn btn-success">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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

    <!-- Bootstrap JS -->
    <?= inc("scripts"); ?>
    <script>
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const link = button.getAttribute('data-link_project');
            const deskripsi = button.getAttribute('data-deskripsi');
            const gambar = button.getAttribute('data-gambar_project');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('old_foto').value = gambar;
            document.getElementById('edit_link').value = link;

        });
    </script>
</body>

</html>