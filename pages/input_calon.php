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
        <main class="container">
            <!-- Existing Calon Penerima Section -->
            <div class="existing-section mt-4">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-list"></i>
                        Calon Penerima yang Sudah Ada
                    </h3>
                </div>
                <div class="criteria-list">
                    <?php
                    // Proses hapus calon penerima
                    if (isset($_GET['hapus'])) {
                        $id_hapus = intval($_GET['hapus']);
                        $query_hapus = "DELETE FROM calon_penerima WHERE id = $id_hapus";
                        $hapus_result = mysqli_query($koneksi, $query_hapus);
                        if ($hapus_result) {
                            echo '<div class="alert alert-success mt-2"><i class="fas fa-check-circle"></i> Calon penerima berhasil dihapus.</div>';
                        } else {
                            echo '<div class="alert alert-danger mt-2"><i class="fas fa-exclamation-triangle"></i> Gagal menghapus: ' . mysqli_error($koneksi) . '</div>';
                        }
                    }

                    // Tampilkan daftar calon penerima
                    $query_existing = "SELECT * FROM calon_penerima ORDER BY id DESC";
                    $result_existing = mysqli_query($koneksi, $query_existing);

                    if (mysqli_num_rows($result_existing) > 0) {
                        while ($row = mysqli_fetch_assoc($result_existing)) {
                            echo '<div class="criteria-item">
                                    <div class="criteria-info">
                                        <div class="criteria-name">
                                            <i class="fas fa-user"></i>
                                            <strong>' . htmlspecialchars($row['nama']) . '</strong>
                                        </div>
                                        <div class="criteria-weight">
                                            <span class="weight-label">Alamat:</span>
                                            <span class="weight-value">' . htmlspecialchars($row['alamat']) . '</span>
                                        </div>
                                        <div class="criteria-weight">
                                            <span class="weight-label">Keterangan:</span>
                                            <span class="weight-value">' . htmlspecialchars($row['keterangan']) . '</span>
                                        </div>
                                    </div>
                                    <div class="criteria-actions">
                                        <a href="?edit=' . $row['id'] . '" class="btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?hapus=' . $row['id'] . '" class="btn-delete" title="Hapus" onclick="return confirm(\'Yakin ingin menghapus calon ini?\')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo '<div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h4>Belum Ada Calon Penerima</h4>
                                <p>Silakan tambahkan calon penerima terlebih dahulu</p>
                            </div>';
                    }
                    ?>
                </div>
            </div>

            <?php
            // Proses edit calon penerima
            if (isset($_GET['edit'])) {
                $id_edit = intval($_GET['edit']);
                $query_edit = mysqli_query($koneksi, "SELECT * FROM calon_penerima WHERE id = $id_edit");
                $data_edit = mysqli_fetch_assoc($query_edit);
                if ($data_edit) {
                    ?>
                    <div class="modal fade show" style="display:block; background:rgba(0,0,0,0.3);" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Calon Penerima</h5>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_edit" value="<?php echo $data_edit['id']; ?>">
                                        <div class="mb-3">
                                            <label for="edit_nama" class="form-label">Nama</label>
                                            <input type="text" id="edit_nama" name="edit_nama" class="form-control" value="<?php echo htmlspecialchars($data_edit['nama']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_alamat" class="form-label">Alamat</label>
                                            <textarea id="edit_alamat" name="edit_alamat" class="form-control" required><?php echo htmlspecialchars($data_edit['alamat']); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_keterangan" class="form-label">Keterangan</label>
                                            <textarea id="edit_keterangan" name="edit_keterangan" class="form-control"><?php echo htmlspecialchars($data_edit['keterangan']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="input_calon.php" class="btn btn-secondary">Batal</a>
                                        <button type="submit" name="update_calon" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <style>
                    body { overflow: hidden; }
                    </style>
                    <?php
                }
            }

            // Proses update calon penerima
            if (isset($_POST['update_calon'])) {
                $id = intval($_POST['id_edit']);
                $nama = mysqli_real_escape_string($koneksi, $_POST['edit_nama']);
                $alamat = mysqli_real_escape_string($koneksi, $_POST['edit_alamat']);
                $keterangan = mysqli_real_escape_string($koneksi, $_POST['edit_keterangan']);
                $query_update = "UPDATE calon_penerima SET nama='$nama', alamat='$alamat', keterangan='$keterangan' WHERE id=$id";
                $update_result = mysqli_query($koneksi, $query_update);
                if ($update_result) {
                    echo '<div class="alert alert-success mt-2"><i class="fas fa-check-circle"></i> Data berhasil diupdate.</div>';
                    echo '<script>setTimeout(function(){ window.location="input_calon.php"; }, 1000);</script>';
                } else {
                    echo '<div class="alert alert-danger mt-2"><i class="fas fa-exclamation-triangle"></i> Gagal update: ' . mysqli_error($koneksi) . '</div>';
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
