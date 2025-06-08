<?php include '../koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Calon Penerima - Sistem Bantuan Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/input-calon.css">
</head>
<body>
    <div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <i class="fas fa-users logo-icon"></i>
                        <div class="logo-text">
                            <h1 class="page-title">Input Calon Penerima</h1>
                            <p class="page-subtitle">Sistem Pendukung Keputusan Bantuan Sosial</p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <a href="../index.php" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Form Section -->
        <main class="container">
            <div class="card shadow mt-4">
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Calon Penerima</label>
                            <input type="text" id="nama" name="nama" class="form-control" required placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Simpan Data
                        </button>
                    </form>

                    <?php
                    if (isset($_POST['submit'])) {
                        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
                        $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
                        $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

                        $query = "INSERT INTO calon_penerima (nama, alamat, keterangan)
                                  VALUES ('$nama', '$alamat', '$keterangan')";
                        $result = mysqli_query($koneksi, $query);

                        if ($result) {
                            echo '<div class="alert alert-success mt-3"><i class="fas fa-check-circle me-1"></i> Calon penerima berhasil disimpan!</div>';
                        } else {
                            echo '<div class="alert alert-danger mt-3"><i class="fas fa-exclamation-circle me-1"></i> Gagal menyimpan: ' . mysqli_error($koneksi) . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <p>&copy; 2024 Sistem Pendukung Keputusan Bantuan Sosial.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
