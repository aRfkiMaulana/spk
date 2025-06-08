<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Pendukung Keputusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <div class="logo-section">
                        <i class="fas fa-hands-helping logo-icon"></i>
                        <div class="logo-text">
                            <h1 class="system-title">Sistem Pendukung Keputusan</h1>
                            <p class="system-subtitle">Bantuan Sosial Masyarakat</p>
                        </div>
                    </div>
                    <div class="admin-info">
                        <i class="fas fa-user-shield"></i>
                        <span>Dashboard Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">
                <div class="welcome-section">
                    <h2 class="welcome-title">Selamat Datang di Dashboard Admin</h2>
                    <p class="welcome-text">Kelola sistem bantuan sosial dengan mudah dan efisien</p>
                </div>

                <!-- Menu Cards -->
                <div class="menu-grid">
                    <a href="pages/input_kriteria.php" class="menu-card kriteria-card">
                        <div class="card-icon">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Input Kriteria</h3>
                            <p class="card-description">Tentukan kriteria penilaian untuk bantuan sosial</p>
                        </div>
                        <div class="card-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="pages/input_calon.php" class="menu-card calon-card">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Input Calon Penerima</h3>
                            <p class="card-description">Tambah data calon penerima bantuan sosial</p>
                        </div>
                        <div class="card-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="pages/input_nilai.php" class="menu-card nilai-card">
                        <div class="card-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Input Nilai Calon</h3>
                            <p class="card-description">Berikan penilaian berdasarkan kriteria</p>
                        </div>
                        <div class="card-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>

                    <a href="pages/hasil_perhitungan.php" class="menu-card hasil-card">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Hasil Perhitungan</h3>
                            <p class="card-description">Lihat hasil akhir sistem pendukung keputusan</p>
                        </div>
                        <div class="card-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Stats Section -->
                <div class="stats-section">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="stat-info">
                                <h4 class="stat-number">4</h4>
                                <p class="stat-label">Menu Utama</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="stat-info">
                                <h4 class="stat-number">SPK</h4>
                                <p class="stat-label">Sistem Terintegrasi</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="stat-info">
                                <h4 class="stat-number">100%</h4>
                                <p class="stat-label">Keamanan Data</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <p>&copy; 2024 Sistem Pendukung Keputusan Bantuan Sosial. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>