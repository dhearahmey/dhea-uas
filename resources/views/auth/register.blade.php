@extends('layouts.app')

@section('content')

<style>

body{
background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.register-card{
border:none;
border-radius:28px;
overflow:hidden;
box-shadow:0 15px 35px rgba(0,0,0,.08);
}

.register-header{
background:linear-gradient(135deg,#7BDFF2,#56D4E8);
padding:30px;
color:white;
text-align:center;
position:relative;
overflow:hidden;
}

.register-header::before{
content:'';
position:absolute;
width:170px;
height:170px;
border-radius:50%;
background:rgba(255,255,255,.15);
right:-40px;
top:-40px;
}

.register-header::after{
content:'';
position:absolute;
width:110px;
height:110px;
border-radius:50%;
background:rgba(255,255,255,.18);
left:-20px;
bottom:-20px;
}

.register-header h3{
font-weight:700;
margin-bottom:8px;
}

.register-header p{
margin:0;
opacity:.95;
}

.form-control{
border-radius:15px;
padding:12px;
border:1px solid #D6F5FA;
}

.form-control:focus{
border-color:#55DDE0;
box-shadow:0 0 0 .2rem rgba(85,221,224,.25);
}

.btn-register{
background:#55DDE0;
color:white;
border:none;
border-radius:30px;
padding:12px 35px;
font-weight:600;
transition:.3s;
}

.btn-register:hover{
background:#3BCFD4;
color:white;
transform:translateY(-2px);
}

.input-icon{
color:#55DDE0;
font-size:18px;
}

</style>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-7 col-md-9">

<div class="card register-card">

<div class="register-header">

<h3>🫧 Register</h3>

<p>Buat akun LaundryKu dan mulai menggunakan layanan kami.</p>

</div>

<div class="card-body p-4">
    <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="row mb-3 align-items-center">
        <label for="name" class="col-md-4 col-form-label text-md-end">
            <i class="fas fa-user input-icon me-2"></i>Name
        </label>

        <div class="col-md-6">
            <input id="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                name="name"
                value="{{ old('name') }}"
                required
                autocomplete="name"
                autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3 align-items-center">
        <label for="email" class="col-md-4 col-form-label text-md-end">
            <i class="fas fa-envelope input-icon me-2"></i>Email Address
        </label>

        <div class="col-md-6">
            <input id="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3 align-items-center">
        <label for="password" class="col-md-4 col-form-label text-md-end">
            <i class="fas fa-lock input-icon me-2"></i>Password
        </label>

        <div class="col-md-6">
            <input id="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                required
                autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-4 align-items-center">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">
            <i class="fas fa-shield-alt input-icon me-2"></i>Confirm Password
        </label>

        <div class="col-md-6">
            <input id="password-confirm"
                type="password"
                class="form-control"
                name="password_confirmation"
                required
                autocomplete="new-password">
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-register px-5">
            <i class="fas fa-user-plus me-2"></i>Register
        </button>

        <div class="mt-4">
            <small class="text-muted">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                   class="text-decoration-none fw-bold"
                   style="color:#55DDE0;">
                    Login di sini
                </a>
            </small>
        </div>
    </div>

</form>

</div>
</div>

</div>
</div>

</div>

@endsection