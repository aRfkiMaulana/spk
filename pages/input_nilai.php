<?php include '../koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Calon Penerima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/nilai-style.css">
</head>
<body>
    <div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <i class="fas fa-user logo-icon"></i>
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

        <div class="form-container">
            <div class="info-box">
                <i>ℹ️</i> Silakan pilih calon penerima terlebih dahulu, kemudian berikan nilai untuk setiap kriteria yang tersedia.
            </div>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="id_calon">Pilih Calon Penerima</label>
                    <select name="id_calon" id="id_calon" class="form-select" required>
                        <option value="">-- Pilih Calon Penerima --</option>
                        <?php
                        $calon = mysqli_query($koneksi, "SELECT * FROM calon_penerima ORDER BY nama");
                        while ($row = mysqli_fetch_assoc($calon)) {
                            echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="kriteria-section">
                    <h3 class="section-title">Penilaian Kriteria</h3>
                    
                    <div class="kriteria-grid">
                        <?php
                        $kriteria = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY nama_kriteria");
                        while ($k = mysqli_fetch_assoc($kriteria)) {
                            echo "<div class='kriteria-item'>";
                            echo "<label class='kriteria-label' for='kriteria_{$k['id']}'>{$k['nama_kriteria']}</label>";
                            echo "<input type='number' step='0.01' min='0' max='100' name='nilai[{$k['id']}]' id='kriteria_{$k['id']}' class='kriteria-input' placeholder='Masukkan nilai (0-100)' required>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn-submit">💾 Simpan Nilai</button>
                </div>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                $id_calon = mysqli_real_escape_string($koneksi, $_POST['id_calon']);
                $nilai = $_POST['nilai'];
                
                $success = true;
                $error_message = "";

                foreach ($nilai as $id_kriteria => $nilai_input) {
                    $nilai_input = mysqli_real_escape_string($koneksi, $nilai_input);
                    $id_kriteria = mysqli_real_escape_string($koneksi, $id_kriteria);
                    
                    // Cek apakah data sudah ada (untuk mencegah duplikat)
                    $cek = mysqli_query($koneksi, "SELECT * FROM nilai_calon WHERE id_calon_penerima = '$id_calon' AND id_kriteria = '$id_kriteria'");
                    
                    if (mysqli_num_rows($cek) > 0) {
                        $query = "UPDATE nilai_calon SET nilai = '$nilai_input' WHERE id_calon_penerima = '$id_calon' AND id_kriteria = '$id_kriteria'";
                    } else {
                        $query = "INSERT INTO nilai_calon (id_calon_penerima, id_kriteria, nilai) VALUES ('$id_calon', '$id_kriteria', '$nilai_input')";
                    }
                    
                    $result = mysqli_query($koneksi, $query);
                    if (!$result) {
                        $success = false;
                        $error_message = mysqli_error($koneksi);
                        break;
                    }
                }

                if ($success) {
                    echo '<div class="alert alert-success">✅ Nilai berhasil disimpan untuk semua kriteria!</div>';
                } else {
                    echo '<div class="alert alert-error">❌ Gagal menyimpan nilai: ' . $error_message . '</div>';
                }
            }
            ?>
        </div>
        <footer class="footer">
            <div class="container">
                <p>&copy; 2024 Sistem Pendukung Keputusan Bantuan Sosial.</p>
            </div>
        </footer>
    </div>
</body>
</html>