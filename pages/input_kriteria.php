<?php include '../koneksi.php'; ?>

<?php
// Proses hapus kriteria
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    $query_hapus = "DELETE FROM kriteria WHERE id = $id_hapus";
    $hapus_result = mysqli_query($koneksi, $query_hapus);
    if ($hapus_result) {
        echo '<div class="alert-success">
                <i class="fas fa-check-circle"></i>
                <div class="alert-content">
                    <h4>Berhasil!</h4>
                    <p>Kriteria berhasil dihapus.</p>
                </div>
              </div>';
    } else {
        echo '<div class="alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="alert-content">
                    <h4>Gagal!</h4>
                    <p>Gagal menghapus kriteria: ' . mysqli_error($koneksi) . '</p>
                </div>
              </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kriteria - Sistem Bantuan Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/input-kriteria.css">
</head>
<body>
    <div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <i class="fas fa-list-check logo-icon"></i>
                        <div class="logo-text">
                            <h1 class="page-title">Input Kriteria Penilaian</h1>
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

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Form Section -->
                        <div class="form-section">
                            <div class="form-header">
                                <div class="form-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="form-title-area">
                                    <h2 class="form-title">Tambah Kriteria Penilaian</h2>
                                    <p class="form-description">Tentukan kriteria dan bobot penilaian untuk bantuan sosial</p>
                                </div>
                            </div>

                            <!-- Alert Messages -->
                            <?php
                            if (isset($_POST['submit'])) {
                                $nama = mysqli_real_escape_string($koneksi, $_POST['nama_kriteria']);
                                $bobot = mysqli_real_escape_string($koneksi, $_POST['bobot']);

                                $query = "INSERT INTO kriteria (nama_kriteria, bobot) VALUES ('$nama', '$bobot')";
                                $result = mysqli_query($koneksi, $query);

                                if ($result) {
                                    echo '<div class="alert-success">
                                            <i class="fas fa-check-circle"></i>
                                            <div class="alert-content">
                                                <h4>Berhasil!</h4>
                                                <p>Kriteria "'.$nama.'" berhasil disimpan dengan bobot '.$bobot.'</p>
                                            </div>
                                          </div>';
                                } else {
                                    echo '<div class="alert-error">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div class="alert-content">
                                                <h4>Gagal!</h4>
                                                <p>Gagal menyimpan kriteria: ' . mysqli_error($koneksi) . '</p>
                                            </div>
                                          </div>';
                                }
                            }
                            ?>

                            <!-- Form -->
                            <div class="form-container">
                                <form method="POST" action="" class="kriteria-form">
                                    <div class="form-group">
                                        <label for="nama_kriteria" class="form-label">
                                            <i class="fas fa-tag"></i>
                                            Nama Kriteria
                                        </label>
                                        <input type="text" 
                                               id="nama_kriteria" 
                                               name="nama_kriteria" 
                                               class="form-input" 
                                               placeholder="Contoh: Penghasilan, Jumlah Tanggungan, dll"
                                               required>
                                        <small class="form-hint">Masukkan nama kriteria penilaian bantuan sosial</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="bobot" class="form-label">
                                            <i class="fas fa-weight-hanging"></i>
                                            Bobot Kriteria
                                        </label>
                                        <div class="input-group">
                                            <input type="number" 
                                                   id="bobot" 
                                                   name="bobot" 
                                                   class="form-input" 
                                                   step="0.01" 
                                                   min="0" 
                                                   max="1" 
                                                   placeholder="0.25"
                                                   required>
                                        </div>
                                        <small class="form-hint">Nilai antara 0.01 - 1.00 (semakin tinggi semakin penting)</small>
                                        <div class="bobot-guide">
                                            <span class="guide-item">0.1-0.3: Rendah</span>
                                            <span class="guide-item">0.3-0.6: Sedang</span>
                                            <span class="guide-item">0.6-1.0: Tinggi</span>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" name="submit" class="btn-submit">
                                            <i class="fas fa-save"></i>
                                            Simpan Kriteria
                                        </button>
                                        <button type="reset" class="btn-reset">
                                            <i class="fas fa-undo"></i>
                                            Reset Form
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Existing Criteria -->
                        <div class="existing-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-list"></i>
                                    Kriteria yang Sudah Ada
                                </h3>
                            </div>

                            <div class="criteria-list">
                                <?php
                                $query_existing = "SELECT * FROM kriteria ORDER BY id DESC";
                                $result_existing = mysqli_query($koneksi, $query_existing);
                                
                                if (mysqli_num_rows($result_existing) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_existing)) {
                                        $bobot_persen = $row['bobot'] * 100;
                                        echo '<div class="criteria-item">
                                                <div class="criteria-info">
                                                    <div class="criteria-name">
                                                        <i class="fas fa-tag"></i>
                                                        '.$row['nama_kriteria'].'
                                                    </div>
                                                    <div class="criteria-weight">
                                                        <span class="weight-label">Bobot:</span>
                                                        <span class="weight-value">'.$row['bobot'].'</span>
                                                        <span class="weight-percent">('.$bobot_persen.'%)</span>
                                                    </div>
                                                </div>
                                                <div class="criteria-actions">
                                                    <button class="btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="?hapus='.$row['id'].'" class="btn-delete" title="Hapus" onclick="return confirm(\'Yakin ingin menghapus kriteria ini?\')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h4>Belum Ada Kriteria</h4>
                                            <p>Silakan tambahkan kriteria penilaian terlebih dahulu</p>
                                          </div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Info Section -->
                        <div class="info-section">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="info-content">
                                    <h4>Panduan Pengisian Kriteria</h4>
                                    <ul>
                                        <li><strong>Nama Kriteria:</strong> Jelaskan aspek penilaian (contoh: Penghasilan, Kondisi Rumah)</li>
                                        <li><strong>Bobot:</strong> Tentukan tingkat kepentingan kriteria (0.01 - 1.00)</li>
                                        <li><strong>Total Bobot:</strong> Pastikan total semua bobot kriteria = 1.00</li>
                                        <li><strong>Prioritas:</strong> Kriteria dengan bobot tinggi lebih berpengaruh pada hasil</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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