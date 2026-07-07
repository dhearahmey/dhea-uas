<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laundry App') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 80vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
        }
        .hero h1 {
            font-size: 4rem;
            font-weight: 700;
            color: white;
        }
        .hero p {
            font-size: 1.25rem;
            color: rgba(255,255,255,0.9);
        }
        .btn-hero {
            background: white;
            color: #764ba2;
            padding: 12px 40px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-hero:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            color: #764ba2;
        }
        .btn-hero-outline {
            border: 2px solid white;
            color: white;
            padding: 12px 40px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-hero-outline:hover {
            background: white;
            color: #764ba2;
        }
        .feature-icon {
            font-size: 3rem;
            color: #764ba2;
        }
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 40px 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
        }
        .nav-link:hover {
            color: white !important;
        }
    </style>
</head>
<body>

    <!-- Flash Message di Welcome -->
    @if(session('success'))
        <div class="container mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: rgba(26, 26, 46, 0.95); position: fixed; width: 100%; top: 0; z-index: 1000;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-tshirt me-2"></i> LaundryKu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#packages">Paket</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-light ms-2 px-4" href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-user me-1"></i> Dashboard
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Laundry <br>Cepat & Bersih</h1>
                    <p class="mb-4">Layanan laundry profesional dengan teknologi modern. Cuci, setrika, dan antar jemput gratis!</p>
                    <div>
                        @guest
                            <a href="{{ route('register') }}" class="btn-hero me-3">
                                <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="btn-hero-outline">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-hero">
                                <i class="fas fa-arrow-right me-2"></i> Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 20px; padding: 40px;">
                        <i class="fas fa-tshirt" style="font-size: 10rem; color: white;"></i>
                        <h3 class="text-white mt-3">LaundryKu</h3>
                        <p class="text-white">Kepercayaan Anda, Prioritas Kami</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Kenapa Memilih Kami?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon"><i class="fas fa-clock"></i></div>
                    <h4 class="mt-3">Cepat</h4>
                    <p>Selesai dalam 24 jam. Express 6 jam tersedia!</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4 class="mt-3">Perawatan Terbaik</h4>
                    <p>Menggunakan deterjen berkualitas dan mesin modern</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon"><i class="fas fa-truck"></i></div>
                    <h4 class="mt-3">Gratis Antar Jemput</h4>
                    <p>Layanan antar jemput gratis untuk customer setia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Preview -->
    <section id="packages" class="py-5" style="background: #f8f9fa;">
        <div class="container">
            <h2 class="text-center mb-5">Paket Laundry</h2>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Cuci Kering</h5>
                            <h3 class="text-primary">Rp 8.000</h3>
                            <p class="text-muted">/ kg</p>
                            <p>Cuci kering biasa, selesai 1 hari</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-center h-100 shadow-sm border-primary">
                        <div class="card-body">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">Populer</span>
                            <h5 class="card-title">Cuci Setrika</h5>
                            <h3 class="text-primary">Rp 12.000</h3>
                            <p class="text-muted">/ kg</p>
                            <p>Cuci + setrika rapi, selesai 1 hari</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Express 6 Jam</h5>
                            <h3 class="text-primary">Rp 20.000</h3>
                            <p class="text-muted">/ kg</p>
                            <p>Express selesai dalam 6 jam</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Dry Clean</h5>
                            <h3 class="text-primary">Rp 25.000</h3>
                            <p class="text-muted">/ kg</p>
                            <p>Dry clean khusus pakaian formal</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-arrow-right me-2"></i> Mulai Pesan
                    </a>
                @else
                    <a href="{{ route('packages.index') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-arrow-right me-2"></i> Lihat Semua Paket
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-tshirt me-2"></i> LaundryKu</h5>
                    <p>Solusi laundry cepat, bersih, dan terpercaya</p>
                </div>
                <div class="col-md-4 text-center">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-phone me-2"></i> 0812-3456-7890</p>
                    <p><i class="fas fa-envelope me-2"></i> info@laundryku.com</p>
                </div>
                <div class="col-md-4 text-end">
                    <h5>Ikuti Kami</h5>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-whatsapp fa-2x"></i></a>
                </div>
            </div>
            <hr class="border-light">
            <p class="text-center mb-0">&copy; {{ date('Y') }} LaundryKu. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>