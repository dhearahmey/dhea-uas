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

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

html{
scroll-behavior:smooth;
}

body{
font-family:'Poppins',sans-serif;
background:#F8FDFF;
}

/* NAVBAR */

.navbar{
background:rgba(86,210,228,.95)!important;
backdrop-filter:blur(12px);
box-shadow:0 8px 20px rgba(0,0,0,.08);
transition:.3s;
}

.navbar-brand{
font-size:1.6rem;
font-weight:700;
color:#fff!important;
}

.nav-link{
color:white!important;
font-weight:500;
margin-left:8px;
transition:.3s;
}

.nav-link:hover{
opacity:.8;
}

.navbar .btn-outline-light{
border-radius:30px;
padding:8px 22px;
}

/* HERO */

.hero{
background:linear-gradient(135deg,#93EAF7,#74DDEB,#58D4E6);
min-height:80vh;
display:flex;
align-items:center;
padding-top:80px;
position:relative;
overflow:hidden;
}

.hero::before{
content:'';
position:absolute;
width:220px;
height:220px;
background:rgba(255,255,255,.15);
border-radius:50%;
right:-70px;
top:-70px;
}

.hero::after{
content:'';
position:absolute;
width:150px;
height:150px;
background:rgba(255,255,255,.18);
border-radius:50%;
left:-40px;
bottom:-40px;
}

.hero h1{
font-size:4rem;
font-weight:700;
color:white;
}

.hero p{
font-size:1.2rem;
color:rgba(255,255,255,.95);
line-height:1.7;
}

.btn-hero{
background:white;
color:#39BDD1;
padding:13px 38px;
border-radius:40px;
font-weight:700;
display:inline-block;
text-decoration:none;
transition:.3s;
}

.btn-hero:hover{
color:#39BDD1;
transform:translateY(-4px);
box-shadow:0 15px 25px rgba(0,0,0,.15);
}

.btn-hero-outline{
border:2px solid white;
color:white;
padding:13px 38px;
border-radius:40px;
display:inline-block;
text-decoration:none;
transition:.3s;
}

.btn-hero-outline:hover{
background:white;
color:#39BDD1;
}

/* FEATURE */

.feature-icon{
width:90px;
height:90px;
border-radius:50%;
background:#ECFCFF;
display:flex;
justify-content:center;
align-items:center;
margin:auto;
font-size:40px;
color:#39BDD1;
transition:.3s;
}

.feature-icon:hover{
transform:translateY(-8px);
box-shadow:0 12px 20px rgba(57,189,209,.25);
}

/* CARD */

.card{
border:none;
border-radius:22px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,.08);
transition:.3s;
}

.card:hover{
transform:translateY(-8px);
box-shadow:0 18px 35px rgba(0,0,0,.12);
}

.card-title{
font-weight:700;
}

.card-body{
padding:28px;
}

.text-primary{
color:#39BDD1!important;
}

.badge.bg-primary{
background:#39BDD1!important;
}

.btn-primary{
background:#39BDD1;
border:none;
border-radius:40px;
font-weight:600;
}

.btn-primary:hover{
background:#28AFC3;
}

#packages{
background:#F3FCFF!important;
}

/* FOOTER */

.footer{
background:linear-gradient(135deg,#6ADBEA,#56D0E2);
color:white;
padding:45px 0;
}

.footer h5{
font-weight:700;
}

.footer a{
color:white;
transition:.3s;
}

.footer a:hover{
opacity:.8;
}

::-webkit-scrollbar{
width:8px;
}

::-webkit-scrollbar-thumb{
background:#65D7E7;
border-radius:30px;
}

::-webkit-scrollbar-track{
background:#EEF9FC;
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
                        <a class="nav-link" href="#features">Tentang</a>
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
                    <p><i class="fas fa-phone me-2"></i> 0821-1730-4711</p>
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