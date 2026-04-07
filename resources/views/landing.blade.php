<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-GAP - Sistem Informasi Pengaduan Sarana dan Prasarana Sekolah</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --navy: #1e3a5f;
            --cyan: #00a8cc;
            --orange: #ff9933;
            --light-bg: #f5f7fa;
            --text-dark: #2c3e50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark);
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--cyan);
        }

        .btn-outline-primary-custom {
            border: 2px solid var(--cyan);
            color: var(--cyan);
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary-custom:hover {
            background: var(--cyan);
            color: white;
        }

        .btn-primary-custom {
            background: var(--cyan);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background: var(--navy);
        }

        /* Hero Section */
        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            background: var(--light-bg);
            padding: 6rem 0 4rem;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .btn-hero {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-hero-primary {
            background: var(--cyan);
            color: white;
            border: none;
        }

        .btn-hero-primary:hover {
            background: var(--navy);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 168, 204, 0.3);
        }

        .btn-hero-secondary {
            background: white;
            color: var(--navy);
            border: 2px solid var(--navy);
        }

        .btn-hero-secondary:hover {
            background: var(--navy);
            color: white;
            transform: translateY(-3px);
        }

        .hero-image {
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.1));
        }

        /* Stats Section */
        .stats-section {
            background: var(--navy);
            color: white;
            padding: 3rem 0;
        }

        .stat-item {
            text-align: center;
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--orange);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--navy);
            text-align: center;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: white;
            border: 2px solid #e1e8ed;
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            border-color: var(--cyan);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--cyan);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 1.5rem;
        }

        .feature-card:hover .feature-icon {
            background: var(--navy);
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: #6c757d;
            line-height: 1.7;
        }

        /* How It Works Section */
        .how-it-works-section {
            padding: 5rem 0;
            background: var(--light-bg);
        }

        .step-card {
            text-align: center;
            padding: 2rem 1rem;
        }

        .step-number {
            width: 70px;
            height: 70px;
            background: var(--orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin: 0 auto 1.5rem;
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 1rem;
        }

        .step-description {
            color: #6c757d;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: var(--cyan);
            color: white;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
        }

        .btn-cta {
            background: white;
            color: var(--cyan);
            padding: 1rem 2.5rem;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-cta:hover {
            background: var(--navy);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        .footer {
            background: var(--navy);
            color: white;
            padding: 3rem 0 1.5rem;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-brand img {
            width: 40px;
            height: 40px;
            margin-right: 0.5rem;
            border-radius: 8px;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .footer-title {
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--cyan);
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            background: var(--cyan);
            color: white;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 2rem;
            padding-top: 1.5rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .cta-title {
                font-size: 2rem;
            }

            .btn-hero {
                padding: 0.8rem 1.8rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('login') }}">
                <img src="{{ asset('images/logo-sigap.png') }}" alt="SI-GAP Logo">
                SI-GAP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cara-kerja">Cara Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}" class="btn btn-primary-custom">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Suarakan Aspirasimu untuk Sekolah Lebih Baik</h1>
                    <p class="hero-subtitle">
                        Platform digital untuk menyampaikan aspirasi dan pengaduan sarana prasarana sekolah secara mudah, cepat, dan transparan.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('login') }}" class="btn btn-hero btn-hero-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                        </a>
                        <a href="#cara-kerja" class="btn btn-hero btn-hero-secondary">
                            <i class="bi bi-play-circle me-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <svg viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg" style="max-width: 500px;">
                            <circle cx="250" cy="200" r="150" fill="#e8eef5" opacity="0.5"/>
                            <rect x="150" y="100" width="200" height="200" rx="15" fill="white" stroke="#00a8cc" stroke-width="4"/>
                            <rect x="180" y="130" width="140" height="12" rx="6" fill="#e8eef5"/>
                            <rect x="180" y="155" width="120" height="12" rx="6" fill="#e8eef5"/>
                            <rect x="180" y="180" width="130" height="12" rx="6" fill="#e8eef5"/>
                            <circle cx="190" cy="220" r="10" fill="#00a8cc"/>
                            <path d="M 187 220 L 189 222 L 193 218" stroke="white" stroke-width="2" fill="none"/>
                            <rect x="210" y="212" width="110" height="16" rx="8" fill="#e8eef5"/>
                            <circle cx="190" cy="255" r="10" fill="#00a8cc"/>
                            <path d="M 187 255 L 189 257 L 193 253" stroke="white" stroke-width="2" fill="none"/>
                            <rect x="210" y="247" width="90" height="16" rx="8" fill="#e8eef5"/>
                            <circle cx="400" cy="80" r="30" fill="#ff9933" opacity="0.8"/>
                            <circle cx="80" cy="320" r="25" fill="#00a8cc" opacity="0.6"/>
                            <rect x="380" y="280" width="40" height="40" rx="8" fill="#1e3a5f" opacity="0.7"/>
                            <circle cx="100" cy="100" r="20" fill="#ff9933" opacity="0.5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">1200+</div>
                        <div class="stat-label">Aspirasi Terkirim</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">950+</div>
                        <div class="stat-label">Aspirasi Selesai</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <p class="section-subtitle">Kemudahan dan transparansi dalam satu platform</p>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h3 class="feature-title">Pengaduan Mudah</h3>
                        <p class="feature-description">
                            Sampaikan aspirasi dengan mudah melalui form yang sederhana dan intuitif. Lengkapi dengan foto untuk dokumentasi.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h3 class="feature-title">Tracking Real-time</h3>
                        <p class="feature-description">
                            Pantau progress penanganan aspirasi kamu secara real-time. Dari status "Baru", "Diproses", hingga "Selesai".
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h3 class="feature-title">Feedback Langsung</h3>
                        <p class="feature-description">
                            Terima feedback dan tanggapan langsung dari admin sekolah untuk setiap aspirasi yang kamu sampaikan.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h3 class="feature-title">Histori Lengkap</h3>
                        <p class="feature-description">
                            Akses semua riwayat aspirasi yang pernah kamu sampaikan dengan mudah dan terorganisir dengan baik.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-funnel"></i>
                        </div>
                        <h3 class="feature-title">Filter & Kategori</h3>
                        <p class="feature-description">
                            Temukan aspirasi berdasarkan tanggal, kategori, atau status dengan sistem filter yang canggih.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Aman & Terpercaya</h3>
                        <p class="feature-description">
                            Data kamu aman dengan sistem enkripsi dan hanya dapat diakses oleh pihak yang berwenang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works-section" id="cara-kerja">
        <div class="container">
            <h2 class="section-title">Cara Kerja</h2>
            <p class="section-subtitle">Proses yang sederhana dan efektif</p>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h3 class="step-title">Daftar/Login</h3>
                        <p class="step-description">
                            Buat akun atau login menggunakan NISN untuk siswa atau email untuk admin
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h3 class="step-title">Buat Aspirasi</h3>
                        <p class="step-description">
                            Isi form aspirasi dengan detail masalah dan upload foto jika diperlukan
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h3 class="step-title">Pantau Progress</h3>
                        <p class="step-description">
                            Lihat status penanganan aspirasi kamu secara real-time
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h3 class="step-title">Terima Feedback</h3>
                        <p class="step-description">
                            Dapatkan tanggapan dan informasi penyelesaian dari admin
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="tentang">
        <div class="container">
            <h2 class="cta-title">Siap Menyuarakan Aspirasimu?</h2>
            <p class="cta-subtitle">
                Bergabunglah dengan ratusan siswa lainnya yang telah mempercayai SI-GAP untuk menyampaikan aspirasi
            </p>
            <a href="{{ route('login') }}" class="btn btn-cta">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-brand d-flex align-items-center">
                        <img src="{{ asset('images/logo-sigap.png') }}" alt="SI-GAP Logo">
                        SI-GAP
                    </div>
                    <p class="footer-description">
                        Sistem Informasi Pengaduan Sarana dan Prasarana Sekolah. Platform digital untuk menyampaikan aspirasi secara mudah, cepat, dan transparan.
                    </p>
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 mb-4 mb-lg-0">
                    <h4 class="footer-title">Menu</h4>
                    <a href="#home" class="footer-link">Beranda</a>
                    <a href="#fitur" class="footer-link">Fitur</a>
                    <a href="#cara-kerja" class="footer-link">Cara Kerja</a>
                    <a href="#tentang" class="footer-link">Tentang</a>
                </div>

                <div class="col-lg-2 col-md-4 mb-4 mb-lg-0">
                    <h4 class="footer-title">Bantuan</h4>
                    <a href="#" class="footer-link">FAQ</a>
                    <a href="#" class="footer-link">Panduan</a>
                    <a href="#" class="footer-link">Kontak</a>
                    <a href="#" class="footer-link">Support</a>
                </div>

                <div class="col-lg-4 col-md-4">
                    <h4 class="footer-title">Kontak</h4>
                    <p class="footer-link mb-2">
                        <i class="bi bi-geo-alt me-2"></i>Jl. Pendidikan No. 123, Jakarta
                    </p>
                    <p class="footer-link mb-2">
                        <i class="bi bi-telephone me-2"></i>+62 812-3456-7890
                    </p>
                    <p class="footer-link">
                        <i class="bi bi-envelope me-2"></i>info@sigap.sch.id
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="mb-0">&copy; 2026 SI-GAP. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.05)';
            }
        });
    </script>
</body>
</html>
