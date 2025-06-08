<?php include '../koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Perhitungan AHP - Sistem Bantuan Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/hasil-style.css">
</head>
<body>
    <div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <i class="fas fa-chart-line logo-icon"></i>
                        <div class="logo-text">
                            <h1 class="page-title">Hasil Perhitungan AHP</h1>
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
                <!-- Summary Cards -->
                <div class="summary-section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="summary-card total-card">
                                <div class="card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="card-info">
                                    <h3 class="card-number">
                                        <?php 
                                        $total_calon = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM calon_penerima"));
                                        echo $total_calon;
                                        ?>
                                    </h3>
                                    <p class="card-label">Total Calon</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="summary-card kriteria-card">
                                <div class="card-icon">
                                    <i class="fas fa-list-check"></i>
                                </div>
                                <div class="card-info">
                                    <h3 class="card-number">
                                        <?php 
                                        $total_kriteria = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kriteria"));
                                        echo $total_kriteria;
                                        ?>
                                    </h3>
                                    <p class="card-label">Kriteria Penilaian</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="summary-card ahp-card">
                                <div class="card-icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="card-info">
                                    <h3 class="card-number">AHP</h3>
                                    <p class="card-label">Metode Perhitungan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="results-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-trophy"></i>
                            Ranking Calon Penerima Bantuan Sosial
                        </h2>
                        <p class="section-description">
                            Hasil perhitungan menggunakan metode AHP (Analytical Hierarchy Process) berdasarkan kriteria yang telah ditetapkan
                        </p>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="results-table">
                                <thead>
                                    <tr>
                                        <th class="rank-col">
                                            <i class="fas fa-medal"></i>
                                            Ranking
                                        </th>
                                        <th class="name-col">
                                            <i class="fas fa-user"></i>
                                            Nama Calon Penerima
                                        </th>
                                        <th class="score-col">
                                            <i class="fas fa-star"></i>
                                            Skor AHP
                                        </th>
                                        <th class="status-col">
                                            <i class="fas fa-check-circle"></i>
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Ambil semua calon penerima
                                    $calon_query = mysqli_query($koneksi, "SELECT * FROM calon_penerima");
                                    $ranking = [];

                                    while ($calon = mysqli_fetch_assoc($calon_query)) {
                                        $id_calon = $calon['id'];
                                        $nama = $calon['nama'];

                                        // Hitung skor AHP untuk calon ini
                                        $nilai_query = mysqli_query($koneksi, "
                                            SELECT nc.nilai, k.bobot 
                                            FROM nilai_calon nc
                                            JOIN kriteria k ON nc.id_kriteria = k.id
                                            WHERE nc.id_calon_penerima = $id_calon
                                        ");

                                        $skor = 0;
                                        while ($row = mysqli_fetch_assoc($nilai_query)) {
                                            $skor += $row['nilai'] * $row['bobot'];
                                        }

                                        // Simpan ke array untuk diranking nanti
                                        $ranking[] = [
                                            'nama' => $nama,
                                            'skor' => $skor
                                        ];
                                    }

                                    // Urutkan berdasarkan skor terbesar
                                    usort($ranking, function($a, $b) {
                                        return $b['skor'] <=> $a['skor'];
                                    });

                                    // Tampilkan hasil
                                    $no = 1;
                                    foreach ($ranking as $r) {
                                        $rank_class = '';
                                        $rank_icon = '';
                                        $status_class = '';
                                        $status_text = '';
                                        
                                        if ($no == 1) {
                                            $rank_class = 'rank-gold';
                                            $rank_icon = '<i class="fas fa-crown"></i>';
                                            $status_class = 'status-prioritas';
                                            $status_text = 'Prioritas Utama';
                                        } elseif ($no == 2) {
                                            $rank_class = 'rank-silver';
                                            $rank_icon = '<i class="fas fa-medal"></i>';
                                            $status_class = 'status-tinggi';
                                            $status_text = 'Prioritas Tinggi';
                                        } elseif ($no == 3) {
                                            $rank_class = 'rank-bronze';
                                            $rank_icon = '<i class="fas fa-award"></i>';
                                            $status_class = 'status-sedang';
                                            $status_text = 'Prioritas Sedang';
                                        } else {
                                            $rank_class = 'rank-normal';
                                            $rank_icon = '<span class="rank-number">' . $no . '</span>';
                                            $status_class = 'status-rendah';
                                            $status_text = 'Prioritas Rendah';
                                        }
                                        
                                        echo "<tr class='table-row {$rank_class}'>
                                                <td class='rank-cell'>
                                                    <div class='rank-badge {$rank_class}'>
                                                        {$rank_icon}
                                                    </div>
                                                </td>
                                                <td class='name-cell'>
                                                    <div class='name-info'>
                                                        <span class='name-text'>{$r['nama']}</span>
                                                    </div>
                                                </td>
                                                <td class='score-cell'>
                                                    <div class='score-info'>
                                                        <span class='score-value'>" . number_format($r['skor'], 4) . "</span>
                                                        <div class='score-bar'>
                                                            <div class='score-fill' style='width: " . ($r['skor'] * 100) . "%'></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class='status-cell'>
                                                    <span class='status-badge {$status_class}'>{$status_text}</span>
                                                </td>
                                            </tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Export Section -->
                <div class="export-section">
                    <div class="export-card">
                        <div class="export-info">
                            <h3 class="export-title">
                                <i class="fas fa-download"></i>
                                Export Hasil
                            </h3>
                            <p class="export-description">Unduh hasil perhitungan dalam format yang Anda inginkan</p>
                        </div>
                        <div class="export-actions">
                            <button class="btn-export pdf-btn">
                                <i class="fas fa-file-pdf"></i>
                                Export PDF
                            </button>
                            <button class="btn-export excel-btn">
                                <i class="fas fa-file-excel"></i>
                                Export Excel
                            </button>
                            <button class="btn-export print-btn" onclick="window.print()">
                                <i class="fas fa-print"></i>
                                Print
                            </button>
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