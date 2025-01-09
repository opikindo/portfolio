<?php
require 'functions.php';
$users = query("SELECT * FROM users","SELECT",true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        // Hapus user
        $user_id = $_POST['delete'];
        $conn->query("DELETE FROM users WHERE id = $user_id");
    } elseif (isset($_POST['update'])) {
        // Update user
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $deskripsi = $_POST['deskripsi'];
        // $foto = $_POST['new_foto'];

        // Jika foto baru diupload
        if ($_FILES['new_foto']['error'] === 0) {
            $foto = 'uploads/' . basename($_FILES['new_foto']['name']);
            move_uploaded_file($_FILES['new_foto']['tmp_name'], $foto);
        }

        $conn->query("UPDATE users SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', deskripsi = '$deskripsi', foto = '$foto' WHERE id = $id");
    } elseif (isset($_POST['create'])) {
        // Tambah user
        $nama = $_POST['new_nama'];
        $jenis_kelamin = $_POST['new_jenis_kelamin'];
        $alamat = $_POST['new_alamat'];
        $deskripsi = $_POST['new_deskripsi'];
        $foto = 'uploads/' . basename($_FILES['new_foto']['name']);
        
        move_uploaded_file($_FILES['new_foto']['tmp_name'], $foto);

        $conn->query("INSERT INTO users (nama, jenis_kelamin, alamat, deskripsi, foto) VALUES ('$nama', '$jenis_kelamin', '$alamat', '$deskripsi', '$foto')");
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Admin Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="container mt-4">
    <h1 class="text-center text-dark">Manage Users</h1>
    <p class="text-center text-muted">Kelola data pengguna sistem</p>
  </header>

  <!-- Table Users -->
  <div class="container mt-5">
    <div class="user">
      <div class="col-12">
        <!-- Button Tambah User -->
        <button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#createModal">Tambah User</button>

        <!-- Tabel Data Users -->
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>Alamat</th>
              <th>Deskripsi</th>
              <th>Foto</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($users)>0): ?>
                <?php $no = 1; ?>
                <?php foreach($users as $user): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $user['nama']; ?></td>
                  <td><?= $user['jenis_kelamin']; ?></td>
                  <td><?= $user['alamat']; ?></td>
                  <td><?= $user['deskripsi']; ?></td>
                  <td><img src="<?= $user['foto']; ?>" alt="Foto" width="50"></td>
                  <td>
                    <!-- Tombol Edit -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $user['id']; ?>" data-nama="<?= $user['nama']; ?>" data-jenis_kelamin="<?= $user['jenis_kelamin']; ?>" data-alamat="<?= $user['alamat']; ?>" data-deskripsi="<?= $user['deskripsi']; ?>" data-foto="<?= $user['foto']; ?>">Edit</button>
                    <!-- Tombol Hapus -->
                    <form method="post" style="display:inline;">
                      <button class="btn btn-danger btn-sm" type="submit" name="delete" value="<?= $user['id']; ?>">Hapus</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="text-center">Tidak ada data pengguna.</td></tr>
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
          <h5 class="modal-title" id="editModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-3">
              <label for="edit_nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="edit_nama" name="nama" required>
            </div>
            <div class="mb-3">
              <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
              <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="edit_alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
            </div>
            <div class="mb-3">
              <label for="edit_deskripsi" class="form-label">Deskripsi</label>
              <textarea class="form-control" id="edit_deskripsi" name="deskripsi" users="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="new_foto" class="form-label">Foto (Opsional)</label>
              <input type="file" class="form-control" name="new_foto" id="new_foto">
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
          <h5 class="modal-title" id="createModalLabel">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="new_nama" class="form-label">Nama</label>
              <input type="text" class="form-control" name="new_nama" required>
            </div>
            <div class="mb-3">
              <label for="new_jenis_kelamin" class="form-label">Jenis Kelamin</label>
              <select class="form-select" name="new_jenis_kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="new_alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control" name="new_alamat" required>
            </div>
            <div class="mb-3">
              <label for="new_deskripsi" class="form-label">Deskripsi</label>
              <textarea class="form-control" name="new_deskripsi" users="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="new_foto" class="form-label">Foto</label>
              <input type="file" class="form-control" name="new_foto" required>
            </div>
            <button type="submit" name="create" class="btn btn-success">Tambah</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <p class="mb-0">Admin Dashboard &copy; 2025</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget; 
      const id = button.getAttribute('data-id');
      const nama = button.getAttribute('data-nama');
      const jenis_kelamin = button.getAttribute('data-jenis_kelamin');
      const alamat = button.getAttribute('data-alamat');
      const deskripsi = button.getAttribute('data-deskripsi');
      const foto = button.getAttribute('data-foto');

      document.getElementById('edit_id').value = id;
      document.getElementById('edit_nama').value = nama;
      document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
      document.getElementById('edit_alamat').value = alamat;
      document.getElementById('edit_deskripsi').value = deskripsi;
    });
  </script>
</body>
</html>