@extends('layouts.app')

@section('content')

<style>

body{
    background:linear-gradient(180deg,#F7FDFF,#EEF9FF,#FFFFFF);
}

.detail-banner{
    background:linear-gradient(135deg,#7BDFF2,#55DDE0);
    color:white;
    border-radius:25px;
    padding:30px;
    margin-bottom:25px;
    position:relative;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

/* Supaya bubble tidak menutupi tombol */
.detail-banner>*{
    position:relative;
    z-index:2;
}

.detail-banner::before{
    content:'';
    position:absolute;
    width:170px;
    height:170px;
    border-radius:50%;
    background:rgba(255,255,255,.15);
    right:-40px;
    top:-50px;
    z-index:0;
    pointer-events:none;
}

.detail-banner::after{
    content:'';
    position:absolute;
    width:110px;
    height:110px;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    left:-20px;
    bottom:-20px;
    z-index:0;
    pointer-events:none;
}

.detail-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.detail-header{
    background:#7BDFF2;
    color:white;
    padding:18px 25px;
}

.info-box{
    background:#F4FDFF;
    border-radius:15px;
    padding:18px;
    margin-bottom:15px;
}

.price{
    font-size:30px;
    color:#0EA5E9;
    font-weight:bold;
}

.btn-bubble{
    background:#55DDE0;
    color:white;
    border:none;
    border-radius:30px;
    padding:10px 22px;
}

.btn-bubble:hover{
    background:#3CCED3;
    color:white;
}

</style>

<div class="container py-4">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="detail-banner">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>🧺 Detail Paket Laundry</h2>

<p class="mb-0">

Lihat informasi lengkap paket laundry pilihanmu 🫧

</p>

</div>

<a href="{{ route('packages.index') }}" class="btn btn-light rounded-pill">

⬅ Kembali

</a>

</div>

</div>

<div class="card detail-card">

<div class="detail-header">

<h4 class="mb-0">

📦 Informasi Paket

</h4>

</div>

<div class="card-body">

<div class="text-center mb-4">

<div style="font-size:70px;">🧺</div>

<h2>{{ $package->name }}</h2>

<div class="price">

Rp {{ number_format($package->price,0,',','.') }}

</div>

<small class="text-muted">/ kg</small>

</div>

<div class="row">

<div class="col-md-6">

<div class="info-box">

<strong>📋 Tipe Paket</strong>

<br>

{{ ucfirst(str_replace('_',' ',$package->type)) }}

</div>

<div class="info-box">

<strong>⏱ Estimasi</strong>

<br>

{{ $package->duration }} Jam

</div>

<div class="info-box">

<strong>📌 Status</strong>

<br>
@if($package->is_active)

<span class="badge bg-success rounded-pill px-3 py-2">

✅ Aktif

</span>

@else

<span class="badge bg-danger rounded-pill px-3 py-2">

❌ Tidak Aktif

</span>

@endif

</div>

</div>

<div class="col-md-6">

<div class="info-box">

<strong>📝 Deskripsi</strong>

<br><br>

{{ $package->description ?? 'Belum ada deskripsi untuk paket ini.' }}

</div>

</div>

</div>

@auth

@if(!Auth::user()->isAdmin())

<div class="text-center mt-4">

<a href="{{ route('orders.create') }}?package={{ $package->id }}"
class="btn btn-bubble btn-lg">

🛒 Pesan Sekarang

</a>

</div>

@endif

@if(Auth::user()->isAdmin())

<div class="text-center mt-4">

<a href="{{ route('packages.edit',$package) }}"
class="btn btn-warning rounded-pill px-4">

✏ Edit

</a>

<form action="{{ route('packages.destroy',$package) }}"
method="POST"
class="d-inline">

@csrf

@method('DELETE')

<button
type="submit"
class="btn btn-danger rounded-pill px-4"
onclick="return confirm('Yakin ingin menghapus paket ini?')">

🗑 Hapus

</button>

</form>

</div>

@endif

@endauth

</div>

</div>

</div>

</div>

</div>

@endsection